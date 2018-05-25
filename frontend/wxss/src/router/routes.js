module.exports = [
  {
    alias: '/',
    path: '/pages/home/home',
    name: 'home',
    meta: {
      nav: true
    },
    config: {
      navigationBarTitleText: '记一笔'
    }
  },
  {
    path: '/pages/list/list',
    name: 'list',
    meta: {
      nav: true
    },
    config: {
      navigationBarTitleText: '账单'
    }
  },
  {
    path: '/pages/me/me',
    name: 'me',
    meta: {
      nav: true
    },
    config: {
      navigationBarTitleText: '个人中心'
    }
  },
  {
    path: '/pages/login/login',
    name: 'login',
    meta: {
      nav: false
    },
    config: {
      navigationBarTitleText: '登录'
    }
  }
]
