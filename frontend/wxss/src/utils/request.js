import Fly from 'flyio'
import store from '../store'
import Path from '../config/path'

const request = new Fly()

request.interceptors.request.use((request) => {
  let token = wx.getStorageSync('access_token')
  request.headers['X-Auth-Token'] = token

  wx.showNavigationBarLoading()
  return request
})

request.interceptors.response.use(
  (response, promise) => {
    wx.hideNavigationBarLoading()
    return promise.resolve(response.data)
  },
  (err, promise) => {
    wx.hideNavigationBarLoading()
    if (err.status == 401) {
      console.log('登录态校验失败')
      // 改变登录态，清空token，跳转到登录页
      store.commit('logout')
      wx.navigateTo({
        url: Path.login
      })
      return promise.resolve({Ret: 401})
    }
    console.error(err)
    wx.showToast({
      title: err.message,
      icon: 'none'
    })
    return promise.resolve()
  }
)

export default request
