import {ref} from "vue";
import {MeiliSearch} from "meilisearch";

const items = ref([]);
const loading = ref(false)
const client = new MeiliSearch({
    host: import.meta.env.VITE_MEILISEARCH_HOST,
    apiKey: import.meta.env.VITE_MEILISEARCH_PUBLISH_KEY,
})
export default () => {
    const index = client.index('users');
    const loadUsers= async (searchText = null) => {
        loading.value = true
        items.value = (await index.search(searchText, {limit: 20})).hits
        loading.value = false
        // axios.get(route('users.search', {search: searchText}))
        //     .then((res) => {
        //         console.log(res)
        //         items.value = res.data.data
        //         loading.value = false
        //     })
    }

    return {
        loading, loadUsers, items
    }
}
