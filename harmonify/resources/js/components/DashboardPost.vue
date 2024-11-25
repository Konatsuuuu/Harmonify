<template>
    <!-- first 2 of the posts -->
    <div class="grid grid-rows-2 gap-2 p-4">
        <div
            v-for="post in posts"
            :key="post.id"
            class="bg-white shadow-md rounded-xl mb-4 p-4 flex items-center cursor-pointer"
            @click="directToPostDetailPage(post.id)"
        >
            <!-- the colored dot -->
            <div
                class="w-4 h-4 rounded-full mr-4 flex-shrink-0"
                :style="{ backgroundColor: getEmotionColor(post.emotion.name) }"
            ></div>
            <p class="text-xl font-bold text-primary-milktea line-clamp">
                {{ post.title }}
            </p>
        </div>
    </div>
</template>

<script>
import {
    db,
    auth,
    collection,
    getDocs,
    getDoc,
    doc,
    getStorage,
    ref,
    query,
    orderBy,
    limit,
} from "@/firebaseConfig";
import { onAuthStateChanged } from "firebase/auth";

export default {
    data() {
        return {
            posts: [],
        };
    },
    methods: {
        async fetchPosts() {
            try {
                const postSnapshot = await getDocs(
                    query(
                        collection(db, "posts"),
                        orderBy("date", "desc"),
                        limit(2)
                    )
                );
                const fetchedPosts = [];
                postSnapshot.forEach((doc) => {
                    const postData = doc.data();
                    const Post = {
                        id: doc.id,
                        title: postData.title,
                        images: Array.isArray(postData.images),
                        emotion: {
                            name: postData.emotion,
                        },
                    };

                    fetchedPosts.push(Post);
                });
                this.posts = fetchedPosts;
                console.log("Posts fetched successfully:", fetchedPosts);
            } catch (error) {
                console.error("Error fetching posts:", error);
                alert("Failed to fetch posts");
            }
        },
        getEmotionColor(emotionName) {
            // color picker
            const emotionColors = {
                Happy: "#f2908b",
                Sad: "#97aed6",
                Calm: "#99b97e",
                Angry: "#f29677",
            };
            return emotionColors[emotionName];
        },
        directToPostDetailPage(id) {
            window.location.href = `/posts/${id}`;
        },
    },
    mounted() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                // User is signed in, see docs for a list of available properties
                // https://firebase.google.com/docs/reference/js/auth.user
                this.userId = user.uid;
                console.log("User ID:", this.userId);
                this.fetchPosts();
            } else {
                // User is signed out
                console.warn("User is signed out");
            }
        });
    },
};
</script>

<style scoped>
/* from https://css-tricks.com/almanac/properties/l/line-clamp/ */
.line-clamp {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
