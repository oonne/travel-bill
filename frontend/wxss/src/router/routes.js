module.exports = [
  {
    alias: '/',
    path: '/pages/home/home',
    name: 'home',
    meta: {
      nav: true
    },
    config: {
      navigationBarTitleText: '快速记账'
    }
  },
  {
    path: '/pages/list/list',
    name: 'list',
    meta: {
      nav: true
    },
    config: {
      navigationBarTitleText: '账单',
      enablePullDownRefresh: true
    }
  },
  {
    path: '/pages/me/me',
    name: 'me',
    meta: {
      nav: true
    },
    config: {
      navigationBarTitleText: ''
    }
  },
  {
    path: '/pages/edit/edit',
    name: 'edit',
    meta: {
      nav: false
    },
    config: {
      navigationBarTitleText: '修改',
    }
  },
  {
    path: '/pages/login/login',
    name: 'login',
    meta: {
      nav: false
    },
    config: {
      navigationBarBackgroundColor: '#f8f8f8',
      navigationBarTextStyle: 'black',
      navigationBarTitleText: '登录'
    }
  }
]
