<template>
    <div class="card mb-2">
        <div class="card-body">
            <form @submit.prevent="handleSubmitComment">
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
                    <button class="btn btn-primary nowrap" type="submit">
                        <i class="fa fa-paper-plane"></i>
                        Post Comment
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
        parentId: {
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
                    parent_id: this.parentId,
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
}
</style>