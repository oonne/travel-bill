export default {
  getFirstAttr (object) {
    for (let i in object) return object[i]
  },
  // Date
  getYYYYMMDD (dateObj) {
    let year = dateObj.getFullYear()
    let month = dateObj.getMonth()+1
    let date = dateObj.getDate()

    if(month<10){
      month = '0' + month
    }
    if(date<10){
      date = '0' + date
    }
    return [year, month, date].join('-')
  },
};
