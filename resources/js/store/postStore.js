import axios from "axios";
import router from "@/router";
import { apiUrl } from "@/config";

const postStore = {
    state: {
        timelinePosts:[],
        profilePosts: [],
        likedPosts: []
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
        }
    },
};

export default postStore;

