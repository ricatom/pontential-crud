import { Loading, Notify } from 'quasar'
import { api } from 'boot/axios'

/**
Retorna lista
*/
const getDevelopers = ({ commit }, props) => {
  const params = { page: !props.filter ? props.current_page : 1, per_page: props.per_page, q: props.filter }
  Loading.show({
    delay: 50
  })
  return new Promise((resolve, reject) => {
    api.get('developers', { params })
      .then((res) => {
        commit('SET_DEVELOPERS', res.data)
        Loading.hide()
        resolve(res.data)
      })
      .catch((err) => {
        console.error(err)
        commit('SET_DEVELOPERS', [])
        Loading.hide()
        reject(err)
      })
  })
}

/**
Retorna lista
*/
const getDeveloper = ({ commit }, id) => {
  Loading.show({
    delay: 50
  })

  return new Promise((resolve, reject) => {
    api.get(`developers/${id}`)
      .then((res) => {
        Loading.hide()
        resolve(res.data)
      })
      .catch((err) => {
        console.error(err)
        Loading.hide()
        reject(err)
      })
  })
}


 /**
 * Novo
 */
const createDeveloper = ({ commit }, developer) => {
  Loading.show({
    delay: 50
  })
  return new Promise((resolve, reject) => {
    api.post(`developers`, developer)
      .then((res) => {
        Notify.create({ message: 'Criado com sucesso !', color: 'teal', position: 'top-right', icon: 'check_circle' })
        Loading.hide()
        resolve(res.data)
      })
      .catch((err) => {
        console.error(err)
        Notify.create({ message: 'Ops, não foi possível salvar, tente novamente!', color: 'negative', position: 'top-right', icon: 'error_outline' })
        Loading.hide()
        reject(err)
      })
  })
}

/***
 * Editar
 */
 const updateDeveloper = ({ commit }, developer) => {
  Loading.show({
    delay: 50
  })
  return new Promise((resolve, reject) => {
    api.put(`developers/${developer.id}`, developer.data)
      .then((res) => {
        Notify.create({ message: 'Salvo com sucesso !', color: 'teal', position: 'top-right', icon: 'check_circle' })
        Loading.hide()
        resolve(res.data)
      })
      .catch((err) => {
        console.error(err)
        Loading.hide()
        reject(err)
      })
  })
}


/***
 * Excluir
 */
 const deleteDeveloper = ({ commit }, id) => {
  Loading.show({
    delay: 50
  })
  return new Promise((resolve, reject) => {
    api.delete(`developers/${id}`)
      .then((res) => {
        Notify.create({ message: 'Excluído com sucesso !', color: 'teal', position: 'top-right', icon: 'check_circle' })
        Loading.hide()
        resolve(res.data)
      })
      .catch((err) => {
        console.error(err)
        Loading.hide()
        reject(err)
      })
  })
 }

 /***
 * Limpa os dados
 */
const clearDeveloper = ({ commit }) => {
  commit('CLEAR_DEVELOPER')
}


export {
  getDevelopers,
  getDeveloper,
  createDeveloper,
  updateDeveloper,
  deleteDeveloper,
  clearDeveloper
}