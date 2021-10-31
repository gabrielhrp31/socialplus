import axios from "axios";
import router from "../router";
import { apiUrl } from "../config";

function arrayRemove(arr, value) {

    return arr.filter(function(ele){
        return ele.id != value;
    });

}

const postStore = {
    state: {
        timelinePosts:[],
        profilePosts: [],
        profileUser: [],
        likedPosts: [],
    },
    mutations: {
        setTimelinePosts(state, posts){
            state.timelinePosts = posts;
        },
        addTimelinePosts(state, posts){
            state.timelinePosts.push(...posts);
        },
        alterTimelinePost(state,newPost){
            state.timelinePosts.forEach((post,index)=>{
               if(post.id===newPost.id){
                   state.timelinePosts[index] = newPost;
               }
            });

            //this is for vue reaction
            state.timelinePosts.push('dog-nail');
            state.timelinePosts.splice(-1,1);
        },
        deleteTimelinePost(state,id) {
            state.timelinePosts = arrayRemove(state.timelinePosts, id);
        },
        setProfilePosts(state, posts){
            state.profilePosts = posts;
        },
        setProfileUser(state, user){
            state.profileUser = user;
        },
        addProfilePosts(state, posts){
            state.profilePosts.push(...posts);
        },
        alterProfilePost(state,newPost){
            state.profilePosts.forEach((post,index)=>{
                if(post.id===newPost.id){
                    state.profilePosts[index] = newPost;
                }
            });

            //this is for vue reaction
            state.profilePosts.push('dog-nail');
            state.profilePosts.splice(-1,1);
        },
        deleteProfilePost(state,id) {
            state.profilePosts = arrayRemove(state.profilePosts, id);
        },
    },
};

export default postStore;

