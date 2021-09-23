<template>
  <q-page padding>
    <!-- content -->
    <div class="q-mb-xl">
      <div class="row">
        <div class="col-md-2 col-sm-2 col-2"></div>  
        <div class="col-md-8 col-sm-8 col-8">
          <!-- Search -->
          <div class="row q-mb-md">
            <q-input dense standout square v-model="filter" placeholder="Pesquisar..." class="bg-white col" @keyup.enter="onRequest" />
            <q-btn  color="primary" square icon="search" unelevated @click="onRequest" />
          </div>

          <div v-if="developers.data">
            <!-- List -->
            <q-list bordered separator class="rounded-borders" v-for="dev in developers.data" :key="dev.id">
              <q-item clickable v-ripple :to="{name: 'developers-edit', params: {id: dev.id}}">
                <q-item-section avatar top>
                  <q-icon name="account_circle" color="blue" size="48px" />
                </q-item-section>
                
                <q-item-section class="q-pt-sm q-pb-sm">
                  <q-item-label class="text-subtitle1">{{ dev.nome }}</q-item-label>
                  <q-item-label v-if="dev.idade" caption>idade: {{dev.idade}} anos | hobby: {{dev.hobby}}</q-item-label>
                </q-item-section>

              </q-item>
            </q-list>

            <!-- Pagination -->
            <div class="q-pa-lg flex flex-center">
              <q-pagination
                v-model="pagination.current_page"
                :max="pagination.pages"
                @click="onRequest"
                direction-links
              />
            </div>
          </div>

          <div v-if="!developers.data" class="text-center fixed-center">
            <q-icon name="fas fa-exclamation-triangle" class="text-grey-5" style="font-size: 2rem;" />
            <div class="text-subtitle2">Não existem dados para serem exibidos</div>
          </div>
        </div>  
        <div class="col-md-2 col-sm-2 col-2"></div>  
      </div>      
    </div>

    
    <q-page-sticky position="bottom-right" :offset="[50, 20]">
      <q-btn fab icon="add" color="primary" :to="{name: 'developers-new'}"/>
    </q-page-sticky>  

  </q-page>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
  name: 'Developers',
  data () {
    return {
      filter: null,
      pagination: {
        current_page: 1, 
        per_page: 5,
        pages: 1
      }
    }
  },
  mounted () {
    this.onRequest()
  },
  computed: {
    ...mapState('developer', ['developers'])
  },
  methods: {
    ...mapActions('developer', ['getDevelopers']),
    onRequest () {
      const props = {
        current_page: this.pagination.current_page,
        per_page: this.pagination.per_page,
        filter: this.filter
      }
      this.getDevelopers(props)
        .then(() => {
          this.pagination.current_page = this.developers.current_page
          this.pagination.pages = this.developers.last_page
        })
    }
  }
}
</script>

