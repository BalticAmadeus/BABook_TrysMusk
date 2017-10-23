import Vue from 'vue';
import router from '../router/index.js'

export default {
      user: {
          authenticated: false,
          id: null,
          name: null
      },
    check: function () {
        let token = localStorage.getItem('id_token')
        if (token !== null) {
            Vue.http.get(
                'user',
                { headers:
                  { 'Authorization': 'Bearer ' + token }
                }
            ).then(response => {
                this.user.authenticated = true
                this.user.id = response.body.result.id
                this.user.name = response.body.result.name
            })
        } else {

        }
    },
    register(context, name, email, password) {
      var data = {
        name: name,
        email: email,
        password: password
      }
      Vue.http.post('register', data).then (response =>
        context.error = false
      ), response => {
        context.response = response.data
        context.error = true
      }
    },
    login: function (context, email, password) {
        Vue.http.post(
            'auth/login',
            {
                email: email,
                password: password
            }
        ).then(response => {
            context.error = false
            if(response.data.result) {
              localStorage.setItem('id_token', response.data.result.token)
              Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token')

              this.user.authenticated = true
              this.user.profile = response.data.result
              router.go('/')
            } else {
              context.error = true
            }
        }, function(response) {
            context.error = true
        })
    },
    logout: function () {
        window.localStorage.removeItem('id_token')
        this.user.authenticated = false
        this.user.profile = null

        router.push('/login');
    }
}
