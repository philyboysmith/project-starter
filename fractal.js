"use strict";

/*
* Require the path module
*/
const path = require("path");

const mandelbrot = require("@frctl/mandelbrot");

const url = 'purpledoor.amillionmonkeys.co.uk';

/*
 * Require the Fractal module
 */
const fractal = (module.exports = require("@frctl/fractal").create());

/*
 * Give your project a title.
 */
fractal.set("project.title", "amillionmonkeys starter");

/*
 * Tell Fractal where to look for components.
 */
fractal.components.set("path", path.join(__dirname, "sg/components"));

/*
 * Tell Fractal where to look for documentation pages.
 */
fractal.docs.set("path", path.join(__dirname, "sg/docs"));

/*
 * Tell the Fractal web preview plugin where to look for static assets.
 */
fractal.web.set("static.path", path.join(__dirname, "dist"));

fractal.web.set("builder.dest", path.join(__dirname, "docs"));

const myCustomisedTheme = mandelbrot({
  skin: "grey",
  panels: ["html", "view", "context", "resources", "info", "notes"]
});

fractal.web.theme(myCustomisedTheme);
