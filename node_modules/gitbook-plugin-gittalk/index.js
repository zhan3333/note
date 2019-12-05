module.exports = {
  book: {
    assets: './assets',
    js: ['plugin.js']
  },
  hooks: {
    'page:before': function(page) {
      var str =
        '<div id="gitalk-container"></div>' +
        '<link rel="stylesheet" href="https://unpkg.com/gitalk/dist/gitalk.css"></link>' +
        '<script src="https://cdn.bootcss.com/blueimp-md5/2.12.0/js/md5.min.js"></script>' +
        '<script src="https://unpkg.com/gitalk/dist/gitalk.min.js"></script>'
      page.content += str
      return page
    }
  }
}
