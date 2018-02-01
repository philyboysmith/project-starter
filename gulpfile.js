"use strict";
const path = require("path");

const filenames = require("gulp-filenames");
const gulp = require("gulp");
const gulpif = require("gulp-if");
const gutil = require("gulp-util");
const plumber = require("gulp-plumber");
const postcss = require("gulp-postcss");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const sassGlob = require("gulp-sass-glob");
const sassLint = require("gulp-sass-lint");
const sourcemaps = require("gulp-sourcemaps");
const svgmin = require("gulp-svgmin");
const svgStore = require("gulp-svgstore");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");

const del = require("del");
const fractal = require("./fractal.js"); // import the Fractal instance configured in the fractal.js file

const logger = fractal.cli.console; // make use of Fractal's console object for logging

const watchOpt = { awaitWriteFinish: true };

const STYLES_WATCHLIST = ["src/scss/**/*.scss", "sg/components/**/*.scss"];

const JS_LINT_WATCHLIST = ["*.js"];

const JS_BUILD_WATCHLIST = ["src/js/**/*.js", "sg/components/**/*.js"];

const SVG_WATCHLIST = ["src/svg/*.svg", "sg/components/**/*.svg"];

let isProduction = false;

/*
* An example of a Gulp task that starts a Fractal development server.
*/

gulp.task("fractal:start", function() {
  const server = fractal.web.server({
    sync: true
  });
  server.on("error", err => logger.error(err.message));
  return server.start().then(() => {
    logger.success(
      `Fractal server is now running at ${server.urls.sync.local}`
    );
  });
});

/*
* An example of a Gulp task that to run a static export of the web UI.
*/

gulp.task("fractal:build", function() {
  const builder = fractal.web.builder();
  builder.on("progress", (completed, total) =>
    logger.update(`Exported ${completed} of ${total} items`, "info")
  );
  builder.on("error", err => logger.error(err.message));
  return builder.build().then(() => {
    logger.success("Fractal build completed!");
  });
});

/* CSS */
gulp.task("css:lint", () =>
  gulp
    .src(STYLES_WATCHLIST)
    .pipe(plumber())
    .pipe(sassLint())
    .pipe(sassLint.format())
);

gulp.task("css:process", function() {
  const postcssPipeline = [require("autoprefixer")];

  if (isProduction) {
    postcssPipeline.push(require("cssnano"));
  }

  return gulp
    .src(["src/scss/styles.scss", "src/scss/styleguide.scss"])
    .pipe(plumber())
    .pipe(gulpif(!isProduction, sourcemaps.init()))
    .pipe(sassGlob())
    .pipe(
      sass.sync({
        precision: 10,
        includePaths: ["./node_modules"]
      })
    )
    .on("error", sass.logError)
    .pipe(postcss(postcssPipeline))
    .pipe(gulpif(!isProduction, sourcemaps.write()))
    .pipe(gulp.dest("dist/css"));
});

gulp.task("css:clean", function() {
  return del(["dist/css"]);
});

gulp.task("css:watch", function() {
  gulp.watch(STYLES_WATCHLIST, watchOpt, gulp.series("css"));
});

gulp.task(
  "css",
  gulp.series(gulp.parallel("css:clean", "css:lint"), "css:process")
);

/* Svg Icons */
gulp.task("svg:process", function() {
  return gulp
    .src(SVG_WATCHLIST)
    .pipe(filenames("icons"))
    .pipe(
      svgmin(function(file) {
        const prefix = path.basename(
          file.relative,
          path.extname(file.relative)
        );
        return {
          plugins: [
            {
              cleanupIDs: {
                prefix: prefix + "-",
                minify: true
              }
            }
          ]
        };
      })
    )
    .pipe(
      svgStore({
        inlineSvg: true
      })
    )
    .pipe(
      rename(function(path) {
        path.basename = "_icons";
        path.extname = ".hbs";
        return path;
      })
    )
    .pipe(gulp.dest("sg/components/"))
    .pipe(
      rename(function(path) {
        path.basename = "inline";
        path.extname = ".svg";
        return path;
      })
    )
    .pipe(gulp.dest("dist/icons"));
});

gulp.task("svg:clean", function() {
  return del(["dist/svg"]);
});

gulp.task("svg", gulp.series("svg:clean", "svg:process"));

gulp.task("svg:watch", function() {
  gulp.watch(SVG_WATCHLIST, watchOpt, gulp.series("svg:process"));
});
/* Fonts */

gulp.task("fonts:copy", function() {
  return gulp.src("src/fonts/**/*").pipe(gulp.dest("dist/fonts"));
});

gulp.task("fonts:clean", function(done) {
  return del(["dist/src/fonts"], done);
});

gulp.task("fonts", gulp.series("fonts:clean", "fonts:copy"));

gulp.task("fonts:watch", function() {
  gulp.watch("src/fonts/**/*", watchOpt, gulp.parallel("fonts"));
});

/* Images */

gulp.task("images:copy", function() {
  return gulp.src("src/img/**/*").pipe(gulp.dest("dist/img"));
});

gulp.task("images:clean", function(done) {
  return del(["dist/img"], done);
});

gulp.task("images", gulp.series("images:clean", "images:copy"));

gulp.task("images:watch", function() {
  gulp.watch("src/img/**/*", watchOpt, gulp.parallel("images"));
});

gulp.task("build:clean", function() {
  return del(["dist"]);
});

/* JS */

gulp.task("js:process", function(cb) {
  return gulp
    .src([
      "./src/js/**/*.js",
      "./sg/components/**/*.js"
    ])
    .pipe(concat("scripts.js"))
    .pipe(gulp.dest("dist/js"))
    .pipe(rename("scripts.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("dist/js"));
});

gulp.task("js:clean", function() {
  return del(["dist/js"]);
});

gulp.task("js:watch", function() {
  // gulp.watch(JS_LINT_WATCHLIST, watchOpt, gulp.series("js:lint"));
  gulp.watch(JS_BUILD_WATCHLIST, watchOpt, gulp.series("js"));
});

gulp.task("js", gulp.series("js:clean", "js:process"));

gulp.task(
  "src",
  gulp.series("svg", gulp.parallel("css", "js", "fonts", "images"))
);

gulp.task(
  "watch",
  gulp.parallel(
    "svg:watch",
    "css:watch",
    "js:watch",
    "fonts:watch",
    "images:watch"
  )
);

gulp.task("dev", gulp.series("src", "fractal:start", "watch"));

gulp.task(
  "build",
  gulp.series(
    function(cb) {
      isProduction = true;

      cb();
    },
    "src",
    "build:clean",
    "fractal:build"
  )
);

gulp.task("default", gulp.series("build"));
