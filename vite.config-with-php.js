import usePHP from "vite-plugin-php";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default {
  plugins: [
    usePHP({
      entry: [
        // frontend
        "index.php",
        "src/pages/**/*.php",
        "src/partials/**/*.php",
        // admin
        "admin/index.php",
        "admin/src/pages/**/*.php",
        "admin/src/partials/**/*.php",
      ],
    }),
    viteStaticCopy({
      targets: [
        { src: "vendor", dest: "" },
        { src: "system", dest: "" },
        // frontend
        { src: "src/php_includes", dest: "src/" },
        // admin
        { src: "admin/src/php_includes", dest: "admin/src/" },
      ],
    }),
  ],
};
