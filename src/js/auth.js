import Vue from 'vue';
import router from '../router/index.js'

export default {
    user: {
        authenticated: false,
        id: null,
        name: null
    },
    check: function () {
        let token = localStorage.getItem('access_token')
        if (token !== null) {
            Vue.http.get(
                'user',
                {
                    headers:
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

        var str = [];
        for(var p in data)
          if (data.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(data[p]));
          }
        data = str.join("&");


        Vue.http.post('register', data,
        { headers: {
            'Content-Type' : 'application/x-www-form-urlencoded'
            }
        }
        ).then(response =>
            context.error = false
        ), response => {
            context.response = response.data
            context.error = true
        }
    },
    login (context, email, password) {
        var data = {
            grant_type: 'password',
            username: email,
            password: password,
        }
        var str = [];
        for(var p in data)
          if (data.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(data[p]));
          }
        data = str.join("&");
        Vue.http.post(
            'login',
            data,{
            headers: {
            'Content-Type' : 'application/x-www-form-urlencoded'
            },
            }
        ).then(response => {
            context.error = false
            if (response.data.result) {
                localStorage.setItem('access_token', response.data.result.token)
                Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token')

                this.user.authenticated = true
                this.user.profile = response.data.result
                router.go('/events')
            } else {
                context.error = true
            }
        }, function (response) {
            context.error = true
        })
    },
    logout: function () {
        window.localStorage.removeItem('access_token')
        this.user.authenticated = false
        this.user.profile = null

        router.go('/login');
    }
}
