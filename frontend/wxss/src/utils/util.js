export default {
  getFirstAttr (object) {
    for (let i in object) return object[i]
  },
};
