<script setup>
import { ref, watch } from 'vue';
import PaginationLinks from './Components/PaginationLink.vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
    
    const props = defineProps({
        users: Object,
        searchTerm: String,
        can: Object,
    })

    const search = ref(props.searchTerm);
    watch(
        search, 
        debounce(
            (q) => router.get('/', { search: q }, { preserveState: true }), 
            500
        )
    );


    // Format Date
    const getDate = (date) =>
        new Date(date).toLocaleDateString("en-us", {
            year: "numeric",
            month: "long",
            day: "numeric",
        })
</script>

<template>
     
    <Head :title="` | ${ $page.component }`" />

    <div>
        <div class="flex justify-end md-4">
            <div class="w-1/4">
                <input type="search" placeholder="Search" v-model="search" />
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="user in users.data" :key="user.id" >
                    <td><img :src="user.avatar ? 'storage/' + user.avatar : 'storage/avatars/user_icon.png'" class="avatar" alt=""></td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ getDate(user.created_at) }}</td>
                    <td>
                        <button class="bg-red-500 w-6 h-6 rounded-full"></button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination links -->

        <div class="mt-4"><PaginationLinks :paginator="users" /></div>

        <!-- <div>
            <Link
                v-for="link in users.links" :key="link.label"
                v-html="link.label" :href="link.url" class="p-1 mx-1"
                :class="
                    { 
                        'text-slate-200' : !link.url, 
                        'text-blue-500 font-medium' : link.active 
                    }
                "
            ></Link>

            <p class="text-slate-600 text-sm">Showing {{ users.from }} to {{ users.to }} of {{ users.toyal }} results</p>
         </div> -->
    </div>
</template>