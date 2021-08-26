import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        comments: [],
        totalComments: 0,
        currentCommentId: null,
    },
    mutations: {
        initialized(state, response) {
            state.comments = response.data.data;
            state.totalComments = response.data.meta.total;
        },
        setCurrentComment(state, commentId) {
            state.currentCommentId = commentId;
        }
    },
    getters: {
        comments: state => state.comments,
        totalComments: state => state.totalComments,
        currentCommentId: state => state.currentCommentId,
    },
    actions: {
        async fetchComments({ commit }) {
            return await axios.get('/comments')
                .then(response => {
                    commit('initialized', response);
                });
        },
    }
});