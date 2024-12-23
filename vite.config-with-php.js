import usePHP from "vite-plugin-php";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default {
  plugins: [
    usePHP({
      entry: [
        // frontend
        "frontend/index.php",
        "frontend/pages/**/*.php",
        "frontend/partials/**/*.php",
        // admin
        "admin/index.php",
        "admin/pages/**/*.php",
        "admin/partials/**/*.php",
      ],
    }),
    viteStaticCopy({
      targets: [
        { src: ".env", dest: "" },
        { src: "vendor", dest: "" },
        { src: "system", dest: "" },
        // frontend
        { src: "frontend/php_includes", dest: "frontend/" },
        // admin
        { src: "admin/php_includes", dest: "admin/" },
      ],
    }),
  ],
};
