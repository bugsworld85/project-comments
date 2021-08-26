<template>
    <div class="comment" v-if="comment !== null">
        <div class="avatar">{{ comment.initials }}</div>

        <div class="comment-container">
            <div class="comment-title">
                <strong class="comment-user">{{ comment.name }}</strong>
            </div>
            <div class="comment-message">
                {{ comment.message }}
            </div>
        </div>
    </div>
</template>

<script>
import CommentForm from "./CommentForm.vue";

export default {
    name: "comment",
    components: {
        CommentForm,
    },
    props: {
        comment: {
            type: Object,
            default: null,
        },
    },
};
</script>

<style lang="scss" scoped>
.comment {
    display: flex;
    align-items: flex-start;
    .avatar {
        background-color: #ddd;
        color: white;
        font-size: 20px;
        font-weight: bold;
        display: block;
        padding: 13px 0;
        line-height: 1;
        border-radius: 100px;
        max-width: 44px;
        width: 100%;
        height: 44px;
        text-align: center;
        margin-right: 10px;
        letter-spacing: -2px;
    }
    .comment-container {
        background-color: #f4f4f4;
        padding: 10px 20px;
        border-radius: 10px 20px;
        .timestamp {
            color: #aaa;
        }
    }
}
</style>
