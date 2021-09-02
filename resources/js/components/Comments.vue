<template>
    <div class="card mb-5">
        <div class="card-body">
            <h5>
                {{ totalComments }}
                {{ totalComments > 1 ? "Comments" : "Comment" }}
            </h5>
            <ul class="comments-container">
                <li
                    v-for="comment in comments"
                    :key="
                        [comment.name, comment.id, comment.parent_id].join('_')
                    "
                >
                    <Comment v-bind="{ comment }" />
                    <CommentReplies v-bind="{ comment }" />
                </li>
            </ul>
            <hr />
            <h4>What can you say about this?</h4>
            <CommentForm />
        </div>
    </div>
</template>

<script>
import CommentForm from "./CommentForm.vue";
import Comment from "./Comment.vue";
import CommentReplies from "./CommentReplies.vue";

export default {
    name: "comments",
    components: {
        CommentForm,
        Comment,
        CommentReplies,
    },
    computed: {
        comments() {
            return this.$store.getters.comments;
        },
        totalComments() {
            return this.$store.getters.totalComments;
        },
    },
};
</script>

<style lang="scss" scoped>
.comments-container {
    list-style: none;
    padding: 0;
    li {
        margin-bottom: 20px;
    }
}
</style>