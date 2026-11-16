# ConnectHub — Employee Social Network

A working PHP 8 social-networking student project featuring registration, login/logout, persistent sessions, editable profiles, public feed, member directory, following/followers, and private messages. Responsive CSS3 design.

## Run locally (Mac with XAMPP)

1. Install XAMPP, start **Apache**, and copy this entire `connecthub` folder into `Applications/XAMPP/xamppfiles/htdocs/` (Mac) or `C:\xampp\htdocs\` (Windows).
2. Open `http://localhost/connecthub/` (adjust the port if Apache is not on port 80).
3. Sign up with a username, email and password (8+ characters).
4. Open a private/incognito window and create a second account to test following and messaging.
5. Post to the feed, edit your profile, follow the other account, and exchange a message.

**No database installation is required for this Week 3 core.** This version uses a server-side JSON data file with file locking. It is a small local classroom prototype, not a production deployment or a MySQL implementation. The textbook's MySQL-based architecture can be added in the next iteration.

## Requirements

- PHP 8.0+ with standard PHP functions and sessions enabled.
- Writable `data/` folder for the web-server user.
- Apache recommended. `data/.htaccess` prevents direct access to stored user data when using Apache.

## Security and scope

- Passwords are hashed with `password_hash`, not stored in plaintext.
- Server-side session authentication and CSRF tokens for all state-changing forms.
- HTML escaping on user content; basic server-side length checks.
- Private messages are filtered to sender/recipient only.
- No image upload yet. Profile avatars are initials; this is an outstanding requirement from the project sample.
- For local demonstrations only: JSON storage is not suitable for multi-server deployments, and the app lacks production protections such as rate limiting, email verification, and hardened deployment configuration.
- Do not publish real personal information or deploy this version to the public internet.

## Week 3 demo outline (3–5 minutes)

1. 0:00–0:30 — Introduce ConnectHub and its purpose.
2. 0:30–1:20 — Sign up, log out and log back in.
3. 1:20–2:10 — Edit a profile and create a public post.
4. 2:10–3:10 — Show member directory, follow someone and review connections.
5. 3:10–4:00 — Send a private message between two test accounts.
6. 4:00–4:30 — Show responsive styling and the GitHub repository; note planned profile image uploads and MySQL migration.

## Project structure

- `index.php` — routes, forms, views and actions
- `lib.php` — sessions, CSRF, persistence, helpers
- `assets/style.css` — responsive styling
- `data/` — server-side local data (not committed)

## GitHub

Upload `index.php`, `lib.php`, `assets/`, `data/.htaccess`, `data/index.php`, `.gitignore`, and this README. Do **not** upload `data/store.json`, which contains private user records and password hashes.
