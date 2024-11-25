import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
import {
    getAuth,
    signOut,
} from "https://www.gstatic.com/firebasejs/11.0.1/firebase-auth.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-analytics.js";
import {
    getFirestore,
    setDoc,
    collection,
    getDocs,
    getDoc,
    deleteDoc,
    doc,
    addDoc,
    query,
    orderBy,
    limit,
} from "https://www.gstatic.com/firebasejs/11.0.1/firebase-firestore.js";
import {
    getStorage,
    ref,
    uploadBytes,
    getDownloadURL,
} from "https://www.gstatic.com/firebasejs/11.0.1/firebase-storage.js";

const firebaseConfig = {
    apiKey: "AIzaSyDOcUz9FFkzTGWT-7GOT5rGZK_SVmmtxfg",
    authDomain: "harmonify-af9f4.firebaseapp.com",
    projectId: "harmonify-af9f4",
    storageBucket: "harmonify-af9f4.firebasestorage.app",
    messagingSenderId: "536611376141",
    appId: "1:536611376141:web:bb3cf2960825757b3e5944",
    measurementId: "G-DGEF2BKFH9",
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const auth = getAuth(app);
const storage = getStorage(app);

export {
    db,
    auth,
    collection,
    getDocs,
    getDoc,
    setDoc,
    deleteDoc,
    doc,
    storage,
    signOut,
    getStorage,
    ref,
    uploadBytes,
    getDownloadURL,
    addDoc,
    query,
    orderBy,
    limit,
};
