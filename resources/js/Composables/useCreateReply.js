import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";


const visibleReply = ref(false)
const discussion = ref(null)
const extraData = ref({})

export default () => {
    const showCreateDiscussionReply = (discussionContent, extraDataContent) => {
        visibleReply.value = true
        discussion.value =  discussionContent
        extraData.value =  extraDataContent
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
        visibleReply, showCreateDiscussionReply, hideCreateDiscussionReply, toggleCreateDiscussionReply, form, discussion, extraData
    }
}
