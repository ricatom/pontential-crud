
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        name: 'developers',
        component: () => import('pages/Developers.vue')
      },
      {
        path: 'new',
        name: 'developers-new',
        component: () => import('pages/Developer.vue')
      },
      {
        path: 'edit/:id',
        name: 'developers-edit',
        component: () => import('pages/Developer.vue')
      },
    ]
  },


  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
