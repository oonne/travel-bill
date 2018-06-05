let config = {
  env: 'prod', // 环境

  dev: {
    envName: '开发环境', // 环境
    api: 'http://api-travel-bill.local/api', // 接口地址
  },
  prod: {
    envName: '生产环境', // 环境
    api: 'https://api-travel-bill.oonne.com/api', // 接口地址
  }
}

export default config
