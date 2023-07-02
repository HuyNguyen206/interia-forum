import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";


const visibleReply = ref(false)
const discussion = ref(null)
const postAuthor = ref({})

export default () => {
    const showCreateDiscussionReply = (discussionContent, postAuthorContent) => {
        visibleReply.value = true
        discussion.value =  discussionContent
        postAuthor.value =  postAuthorContent
    }

    const hideCreateDiscussionReply = () => {
        visibleReply.value = false
    }

    const toggleCreateDiscussionReply = () => {
        visibleReply.value = !visibleReply.value
    }

    const form = useForm({
        body: ''
    })

    return {
        visibleReply, showCreateDiscussionReply, hideCreateDiscussionReply, toggleCreateDiscussionReply, form, discussion, postAuthor
    }
}
