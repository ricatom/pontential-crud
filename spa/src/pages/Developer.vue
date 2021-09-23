<template>
  <q-page padding class="bg-white">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-3"></div>
      <div class="col-md-6 col-sm-6 col-6">
        <div class="q-mt-lg">
          <div class="row q-col-gutter-x-sm q-gutter-y-xs">
            <div class="col-md-12 col-sm-12 col-12">
              <q-input outlined v-model="data.nome" label="Nome completo*" :rules="[val => !!val || 'Preenchimento obrigatório']" maxlength="255"/>
            </div>
            <div class="col-md-12 col-sm-12 col-12">
              <q-input outlined v-model="data.hobby" label="Hobby" maxlength="255"/>
            </div>
            <div class="col-md-4 col-sm-4 col-4 q-mt-md">
              <q-input outlined v-model="data.datanascimento" label="Data nascimento" type="date"/>
            </div>
            <div class="col-md-4 col-sm-4 col-4 q-mt-md">
              <q-input outlined v-model="data.idade" label="Idade" type="number"/>
            </div>
            <div class="col-md-4 col-sm-4 col-4 q-mt-md">
              <q-select outlined v-model="data.sexo" :options="genders" emit-value map-options label="Sexo"/>
            </div>
          </div>
        </div>
        <div class="row q-col-gutter-x-sm q-gutter-y-xs">
          <div class="col-md-6 col-sm-6 col-6 q-mt-md">
            <q-btn outline class="q-mt-md q-pt-xs q-pb-xs" label="Voltar" icon="arrow_back" :to="{name: 'developers'}"></q-btn>
            <q-btn v-if="id" outline class="q-mt-md q-pt-xs q-pb-xs q-ml-xl" label="Excluir" icon="delete" @click="confirm_delete = true" />
          </div>
          <div class="col-md-6 col-sm-6 col-6 q-mt-md">
            <q-btn color="primary" class="full-width q-mt-md q-pt-xs q-pb-xs" label="Salvar" :disable="!data.nome" @click="save(data)"/>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-3"></div>  
    </div>

    <!-- Dialog delete -->
    <q-dialog v-model="confirm_delete" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="delete" color="primary" text-color="white" />
          <span class="q-ml-sm">Deseja realmente excluir este desenvolvedor?</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
          <q-btn flat label="Excluir" color="primary" @click="remove" />
        </q-card-actions>
      </q-card>
    </q-dialog>      
  </q-page>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'Developer',
  data () {
    return {
      id: null,
      data: { nome: '', sexo: '', idade: '', hobby: '', datanascimento: ' ' },
      genders: [{ value: 'M', label: 'Masculino' }, { value: 'F', label: 'Feminino' }],
      confirm_delete: false
    }
  },
  mounted () {
    this.id = this.$route.params.id
    this.onRequest()
  },
  methods: {
    ...mapActions('developer', ['getDeveloper', 'createDeveloper', 'updateDeveloper', 'clearDeveloper', 'deleteDeveloper']),
    onRequest () {
      this.clearDeveloper()
      if (this.id !== undefined) {
        this.getDeveloper(this.id)
        .then((res) => {
          this.data = res
        })
      }
    },
    save (data) {
      if (this.id === undefined) {
        this.createDeveloper(data)
          .then(() => {
            this.$router.go(-1)
          })
      } else {
        this.updateDeveloper({ id: this.id, data})
          .then(() => {
            this.$router.go(-1)
          })
      }
    },
    remove() {
      this.deleteDeveloper(this.id)
        .then(() => {
          this.$router.go(-1)
        })
    }
  }
}
</script>
