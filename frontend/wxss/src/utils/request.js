import Fly from 'flyio'

const request = new Fly()

request.interceptors.request.use((request) => {
  let token = wx.getStorageSync('token')
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
    wx.showToast({
      title: err.message,
      icon: 'none'
    })
    return promise.resolve()
  }
)

export default request
