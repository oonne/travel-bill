import config from './config'

let env = config.env
let url = config[env]

export default url
