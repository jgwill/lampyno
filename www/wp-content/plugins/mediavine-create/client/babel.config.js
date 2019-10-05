module.exports = api => {
  api.cache(false)
  return {
    "presets": process.env.NODE_ENV === 'test'
      ? ["@babel/preset-env"]
      : ["preact-cli/babel"]
  }
}