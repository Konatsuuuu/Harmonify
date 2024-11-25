<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div
            class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-primary-milktea"
        >
            <div
                class="flex justify-between ml-4 space-x-3 text-primary-milktea"
            >
                <div
                    class="flex items-center mb-3 ml-4 space-x-3 text-primary-milktea"
                >
                    <BackButton />
                    <p class="text-3xl font-bold">Posts</p>
                </div>
            </div>

            <div
                class="overflow-y-auto bg-white shadow-lg rounded-xl m-4 p-4 pl-8 pr-8"
            >
                <div class="flex items-center justify-between">
                    <div class="text-3xl font-bold text-primary-milktea">
                        {{ post.title }}
                    </div>
                    <img
                        :src="post.emotion.icon"
                        :alt="post.emotion.name"
                        class="w-20 h-20 rounded-full bubble"
                    />
                </div>
                <div class="text-md">
                    <span class="font-bold">By </span>{{ post.username }}
                    <span
                        v-if="isCurrentUser(post.userId)"
                        class="ml-4 text-red-500 underline cursor-pointer"
                        @click="deletePost"
                    >
                        Delete Post
                    </span>
                </div>
                <p class="text-md mb-4">{{ post.content }}</p>
                <div class="w-full grid grid-cols-3 gap-4">
                    <img
                        v-for="(img, index) in post.images"
                        :key="index"
                        :src="img"
                        class="w-full rounded-lg"
                    />
                </div>
                <hr class="my-4 border-gray-300" />
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold my-2">Replies</div>
                    <button
                        class="px-4 py-2 bg-primary-milktea text-white rounded"
                        @click="toggleReplyInput"
                    >
                        Reply
                    </button>
                </div>
                <div v-if="showReplyInput" class="my-4">
                    <textarea
                        v-model="newReply"
                        class="w-full p-2 rounded mb-2"
                        placeholder="Reply"
                    ></textarea>
                    <button
                        class="px-4 py-2 bg-[#b28666a0] text-white rounded"
                        @click="submitReply"
                    >
                        Submit
                    </button>
                </div>
                <div
                    v-for="(reply, index) in replies"
                    :key="index"
                    class="overflow-y-auto bg-primary-milktea bg-opacity-30 rounded-xl p-4 my-2"
                >
                    <div class="text-primary-milktea p-2">
                        <span class="font-bold">{{ reply.username }}:</span>
                        {{ reply.content }}
                    </div>
                    <span
                        v-if="isCurrentUser(reply.userId)"
                        class="p-2 text-red-500 underline cursor-pointer"
                        @click="deleteReply(reply, index)"
                    >
                        Delete Reply
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    auth,
    db,
    doc,
    getDoc,
    collection,
    addDoc,
    getDocs,
    query,
    orderBy,
    limit,
    deleteDoc,
} from "@/firebaseConfig";

import BackButton from "./BackButton.vue";

export default {
    components: {
        BackButton,
    },
    data() {
        return {
            post: {
                title: "",
                content: "",
                username: "",
                userId: "",
                image: [],
                emotion: {
                    name: "",
                    icon: "",
                },
            },
            replies: [],
            showReplyInput: false,
            newReply: "",
            emotions: [
                { name: "Happy", icon: "/svg/happy_bubble.svg" },
                { name: "Calm", icon: "/svg/calm_bubble.svg" },
                { name: "Sad", icon: "/svg/sad_bubble.svg" },
                { name: "Angry", icon: "/svg/angry_bubble.svg" },
            ],
        };
    },
    async created() {
        const postId = document.getElementById("postdetail-app").dataset.id;
        await this.fetchPost(postId);
        await this.fetchReplies(postId);
    },
    methods: {
        async fetchPost(postId) {
            try {
                const postSnapshot = await getDoc(doc(db, "posts", postId));

                if (postSnapshot.exists()) {
                    const postData = postSnapshot.data();
                    this.post = {
                        id: postSnapshot.id,
                        userId: postData.userId,
                        username: postData.username,
                        title: postData.title,
                        content: postData.content,
                        images: Array.isArray(postData.images)
                            ? postData.images
                            : [],
                        emotion: {
                            name: postData.emotion,
                            icon: this.getEmotionIcon(postData.emotion),
                        },
                        date: postData.date,
                    };
                } else {
                    alert("Post not found.");
                }
            } catch (error) {
                console.error("Error fetching post:", error);
                alert("Failed to fetch post. Please try again.");
            }
        },
        async fetchReplies(postId) {
            try {
                const repliesSnapshot = await getDocs(
                    query(
                        collection(db, "posts", postId, "replies"),
                        orderBy("date", "asc")
                    )
                );
                const fetchedReplies = [];
                repliesSnapshot.forEach((doc) => {
                    const replyData = doc.data();
                    fetchedReplies.push({
                        id: doc.id,
                        userId: replyData.userId,
                        username: replyData.username,
                        content: replyData.content,
                        date: replyData.date,
                    });
                });
                this.replies = fetchedReplies;
            } catch (error) {
                console.error("Error fetching replies:", error);
            }
        },
        getEmotionIcon(emotionName) {
            const emotion = this.emotions.find((e) => e.name === emotionName);
            return emotion.icon;
        },
        toggleReplyInput() {
            this.showReplyInput = !this.showReplyInput;
        },
        async submitReply() {
            try {
                const user = auth.currentUser;
                const userDoc = doc(db, "users", user.uid);
                const userSnapshot = await getDoc(userDoc);
                const userId = user.uid;
                const username = userSnapshot.data().username;

                const postId =
                    document.getElementById("postdetail-app").dataset.id;
                const replyData = {
                    content: this.newReply,
                    userId,
                    username,
                    date: new Date(),
                };
                await addDoc(
                    collection(db, "posts", postId, "replies"),
                    replyData
                );
                this.replies.push(replyData);
                this.newReply = "";
                this.showReplyInput = false;
            } catch (error) {
                console.error("Error submitting reply:", error);
            }
        },
        isCurrentUser(userId) {
            const user = auth.currentUser;
            return user && user.uid === userId;
        },
        async deletePost() {
            try {
                const postId =
                    document.getElementById("postdetail-app").dataset.id;
                await deleteDoc(doc(db, "posts", postId));
                alert("Post deleted successfully!");
                window.location.href = "/posts";
            } catch (error) {
                console.error("Error deleting post:", error);
            }
        },
        async deleteReply(reply, index) {
            try {
                const postId =
                    document.getElementById("postdetail-app").dataset.id;
                const replyDocRef = doc(
                    db,
                    "posts",
                    postId,
                    "replies",
                    reply.id
                );
                await deleteDoc(replyDocRef);

                this.replies.splice(index, 1);
                alert("Reply deleted successfully!");
            } catch (error) {
                console.error("Error deleting reply:", error);
            }
        },
    },
};
</script>
