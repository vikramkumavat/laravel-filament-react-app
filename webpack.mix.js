require("dotenv").config(); // 👈 load .env variables
const mix = require("laravel-mix");

// Access your .env value
const assetDomain = process.env.APP_URL || "/";

mix.js("resources/js/app.jsx", "public/js")
    .react()
    .postCss("resources/css/app.css", "public/css", [])
    .setResourceRoot(assetDomain) // 👈 sets base URL for relative asset paths
    .disableNotifications() // 👈 Disables success/error notifications
    .browserSync({
        host: "local.auction",
        files: [
            "app/**/*.php",
            "resources/views/**/*.blade.php",
            "resources/js/**/*.jsx",
            "resources/css/**/*.css",
            "public/js/**/*.js",
            "public/css/**/*.css",
        ],
        open: false,
        notify: false,
    });

// ✅ Add versioning only when NOT in production
if (!mix.inProduction()) {
    mix.version();
}
