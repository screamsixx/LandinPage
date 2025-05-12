module.exports = function (eleventyConfig) {
  // set copy asset folder to dist
  eleventyConfig.addPassthroughCopy("docs");
  eleventyConfig.addPassthroughCopy("css");
  eleventyConfig.addPassthroughCopy("fonts");
  eleventyConfig.addPassthroughCopy("img");
  eleventyConfig.addPassthroughCopy("js");

  eleventyConfig.addPassthroughCopy("sitemap.xml");
  eleventyConfig.addPassthroughCopy("favicon.png");

  eleventyConfig.addPassthroughCopy("mailing");

  // set input and output folder
  return {
    dir: { input: "pages", output: "dist" },
  };
};
