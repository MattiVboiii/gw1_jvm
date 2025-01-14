import usePHP from "vite-plugin-php";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default {
  plugins: [
    usePHP({
      entry: [
        "index.php",
        // frontend
        "frontend/index.php",
        "frontend/pages/**/*.php",
        "frontend/partials/**/*.php",
        // backend
        "backend/index.php",
        "backend/pages/**/*.php",
        "backend/partials/**/*.php",
      ],
      rewriteUrl(requestUrl) {
        if ([".js", ".css"].some((s) => requestUrl.pathname.includes(s))) {
          return;
        }

        // requestUrl.search = '_request_=' + requestUrl.pathname;
        // requestUrl.pathname = 'index.php';

        return requestUrl;
      },
    }),
    viteStaticCopy({
      targets: [
        { src: ".env", dest: "" },
        { src: "vendor", dest: "" },
        { src: "system", dest: "" },
        { src: ".htaccess", dest: "" },
        // frontend
        { src: "frontend/php_includes", dest: "frontend/" },
        // backend
        { src: "backend/php_includes", dest: "backend/" },
        // uploads folder
        { src: "uploads/.upload", dest: "uploads/" },
      ],
    }),
  ],
};
