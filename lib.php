<?php
declare(strict_types=1);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(['httponly'=>true,'samesite'=>'Lax','secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
    session_start();
}
const STORE = __DIR__ . '/data/store.json';
function db(): array {
    $f=fopen(STORE,'c+'); if(!$f) throw new RuntimeException('Cannot open data store');
    flock($f,LOCK_SH); $raw=stream_get_contents($f); flock($f,LOCK_UN); fclose($f);
    $d=$raw ? json_decode($raw,true) : null;
    return is_array($d) ? $d : ['users'=>[], 'posts'=>[], 'follows'=>[], 'messages'=>[]];
}
function mutate(callable $fn): mixed {
    $f=fopen(STORE,'c+'); if(!$f) throw new RuntimeException('Cannot open data store');
    flock($f,LOCK_EX); rewind($f); $raw=stream_get_contents($f);
    $d=$raw ? json_decode($raw,true) : null;
    if(!is_array($d)) $d=['users'=>[],'posts'=>[],'follows'=>[],'messages'=>[]];
    try { $result=$fn($d); rewind($f); ftruncate($f,0); fwrite($f,json_encode($d,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR)); fflush($f); return $result; }
    finally { flock($f,LOCK_UN); fclose($f); }
}
function e(mixed $s): string {return htmlspecialchars((string)$s, ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function user(): ?string {return $_SESSION['user'] ?? null;}
function csrf(): string {return $_SESSION['csrf'] ??= bin2hex(random_bytes(24));}
function check_csrf(): void {if(!hash_equals(csrf(),(string)($_POST['csrf']??''))) {http_response_code(403);exit('Invalid security token. Refresh the page and try again.');}}
function go(string $page='home'): never {header('Location: index.php?page='.rawurlencode($page));exit;}
function flash(string $message,string $type='success'): void {$_SESSION['flash']=['message'=>$message,'type'=>$type];}
function require_user(): string {if(!user()){flash('Please log in first.','error');go('login');}return user();}
function initials(string $name): string {return strtoupper(substr($name,0,2));}
function avatar(string $name, string $size=''): string {return '<span class="avatar '.e($size).'">'.e(initials($name)).'</span>';}
function active(string $p,string $current): string {return $p===$current?'active':'';}
