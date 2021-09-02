<template>
    <div class="card mb-2">
        <div class="card-body">
            <form @submit.prevent="handleSubmitComment">
                <blockquote v-if="comment !== null">
                    <span class="d-block"
                        >Reply to <strong>{{ comment.name }}</strong></span
                    >
                    <em>{{ comment.message }}</em>
                </blockquote>
                <span class="text-danger" v-if="errors.length !== ''">
                    {{ errors }}
                </span>
                <p>
                    <textarea
                        rows="3"
                        class="form-control"
                        v-model="message"
                        placeholder="Write your comment here"
                        ref="messageField"
                    ></textarea>
                </p>
                <p class="flex center mb-0">
                    <input
                        type="text"
                        class="form-control mr-2"
                        placeholder="Please enter your name"
                        v-model="name"
                    />
                    <button
                        class="btn btn-secondary nowrap mr-2"
                        v-if="comment !== null"
                        type="button"
                        @click="handleCancelReply"
                    >
                        <i class="fa fa-times"></i>
                        <span>Cancel Reply</span>
                    </button>
                    <button class="btn btn-primary nowrap" type="submit">
                        <i class="fa fa-paper-plane"></i>
                        <span>Post Comment</span>
                    </button>
                </p>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "comment-form",
    props: {
        comment: {
            type: Number,
            default: null,
        },
    },
    data() {
        return {
            name: "",
            message: "",
            errors: "",
        };
    },
    mounted() {
        this.$refs.messageField.focus();
    },
    methods: {
        handleCancelReply() {
            this.$store.commit("setCurrentComment", null);
        },
        reset() {
            this.name = "";
            this.message = "";
        },
        async handleSubmitComment() {
            this.errors = "";

            await axios
                .post("/comment/submit", {
                    name: this.name,
                    message: this.message,
                    parent_id: this.comment.id,
                })
                .then((response) => {
                    this.reset();

                    this.$store.dispatch("fetchComments");
                    this.$emit("submitted");
                })
                .catch(({ request, response }) => {
                    if (typeof response !== "undefined") {
                        this.errors = response.data.message;
                    }
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.card {
    background-color: #f1f1f1;
    border: none;
    blockquote {
        em {
            color: #bbb;
            border-left: 3px solid;
            margin-left: 10px;
            padding-left: 10px;
        }
    }
}

@media only screen and (max-width: 560px) {
    .card {
        .btn {
            span {
                display: none;
            }
        }
    }
}
</style>