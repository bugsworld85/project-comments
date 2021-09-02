<template>
    <div class="comment-replies-container" v-if="comment !== null">
        <div>
            <span v-if="allowReply && level < maxLevel">
                <span class="pointer strong" @click="handleReplyAttempt()">
                    {{ isCurrentComment ? "Cancel Reply" : "Reply" }}
                </span>
                &middot;
            </span>
            <span class="comment-age">{{ comment.age }}</span>
        </div>
        <ul class="comments-container">
            <li
                v-for="_comment in comment.children"
                :key="
                    [_comment.name, _comment.id, _comment.parent_id].join('_')
                "
            >
                <Comment v-bind="{ comment: _comment }" />
                <comment-replies
                    v-bind="{
                        comment: _comment,
                        allowReply: true,
                        level: level + 1,
                    }"
                />
            </li>
            <li v-if="isCurrentComment">
                <CommentForm :comment="comment" @submitted="handleSubmitted" />
            </li>
        </ul>
    </div>
</template>

<script>
import CommentForm from "./CommentForm.vue";
import Comment from "./Comment.vue";

export default {
    name: "comment-replies",
    components: {
        CommentForm,
        Comment,
    },
    props: {
        comment: {
            type: Object,
            default: null,
        },
        allowReply: {
            type: Boolean,
            default: true,
        },
        level: {
            type: Number,
            default: 1,
        },
        maxLevel: {
            type: Number,
            default: 3,
        },
    },
    computed: {
        isCurrentComment() {
            return (
                this.$store.state.currentComment !== null &&
                this.$store.state.currentComment.id === this.comment.id
            );
        },
    },
    methods: {
        handleSubmitted() {
            this.$store.commit("setCurrentComment", null);
        },
        handleReplyAttempt() {
            this.$store.commit(
                "setCurrentComment",
                this.isCurrentComment ? null : this.comment
            );
        },
    },
};
</script>

<style lang="scss" scoped>
.comment-replies-container {
    padding-left: 50px;
    border-left: 2px solid #f2f2f2;
    margin-left: 20px;
    .comment-age {
        color: #bbb;
    }
    .comments-container {
        list-style: none;
        padding: 0;
        li {
            margin-bottom: 10px;
        }
    }
}

@media only screen and (max-width: 764px) {
    .comment-replies-container {
        padding-left: 0;
    }
}
</style>

<style lang="scss">
.comment-replies-container {
    .comments-container {
        li {
            .comment {
                .avatar {
                    max-width: 35px;
                    height: 35px;
                    font-size: 16px;
                    padding: 10px 0;
                }
            }
        }
    }
}
</style>