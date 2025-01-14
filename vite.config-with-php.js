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

        switch (true) {
          case "" == requestUrl.pathname:
            return "/frontend/index.php";
          case requestUrl.pathname.startsWith("/club/"):
            requestUrl.search = `?id=${requestUrl.pathname.slice(6)}`;
            requestUrl.pathname = "/frontend/pages/detail.php";
            return requestUrl;
          case "/admin" == requestUrl.pathname:
            requestUrl.pathname = "/backend/pages/home.php";
            return requestUrl;
          case "/admin/login" == requestUrl.pathname:
            requestUrl.pathname = "/backend/pages/login.php";
            return requestUrl;
          case "/admin/clubs" == requestUrl.pathname:
            requestUrl.pathname = "/backend/pages/clubs.php";
            return requestUrl;
          case requestUrl.pathname.startsWith("/admin/clubs/edit/"):
            requestUrl.search = `?id=${requestUrl.pathname.slice(18)}`;
            requestUrl.pathname = "/backend/pages/clubEdit.php";
            return requestUrl;
          case "/admin/clubs/create" == requestUrl.pathname:
            requestUrl.pathname = "/backend/pages/clubCreate.php";
            return requestUrl;
          case "/404" == requestUrl.pathname:
            requestUrl.pathname = "/frontend/pages/404.php";
            return requestUrl;
        }
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
