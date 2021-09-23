const SET_DEVELOPERS = (state, data) => {
  state.developers = data
}

const SET_DEVELOPER = (state, data) => {
  state.developer = data
}

const CLEAR_DEVELOPER = (state) => {
  state.developer = {}
}

export {
  SET_DEVELOPERS,
  SET_DEVELOPER,
  CLEAR_DEVELOPER
}
