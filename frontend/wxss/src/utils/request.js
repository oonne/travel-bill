import wx from 'wx'
import Fly from 'flyio'

const request = new Fly()

request.interceptors.request.use((request) => {
  let cookie = {
    'client_type': wx.getStorageSync('client_type'),
    'client_type.sig': wx.getStorageSync('client_type.sig'),
    'fid': wx.getStorageSync('fid'),
    'fid.sig': wx.getStorageSync('fid.sig'),
    'session_proxy_id': wx.getStorageSync('session_proxy_id'),
    'session_proxy_id.sig': wx.getStorageSync('session_proxy_id.sig'),
    'c_skey': wx.getStorageSync('c_skey'),
    'c_skey.sig': wx.getStorageSync('c_skey.sig')
  }
  
  let cookieStr = ''
  for (var key in cookie) {
    cookieStr += `${key}=${cookie[key]}; ` 
  }

  request.headers['Cookie'] = cookieStr

  wx.showNavigationBarLoading()
  return request
})

request.interceptors.response.use(
  (response, promise) => {
    // 如果有cookie，则把cookie写到缓存中
    let cookieStr = response.headers['set-cookie']
    if (cookieStr) {
      let cookieArr = cookieStr.split(',')
      cookieArr.map(itemStr => {
        let itemArr = itemStr.match(/(\S*)(=)(\S*)(;)(\S*)/)

        if (itemArr) {
          let key = itemArr[1]
          let val = itemArr[3]
          wx.setStorageSync(key, val)
        }
      })
    }

    wx.hideNavigationBarLoading()
    return promise.resolve(response.data)
  },
  (err, promise) => {
    wx.hideNavigationBarLoading()
    wx.showToast({
      title: err.message,
      icon: 'none'
    })
    return promise.resolve()
  }
)

export default request
