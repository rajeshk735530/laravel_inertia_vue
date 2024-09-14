<script setup>
    import { useForm } from '@inertiajs/vue3';
    import TextInput from '../Components/TextInput.vue';

    const form = useForm ({
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
        avatar: null,
        preview: null,
    });

    const change = (e) => {
        form.avatar = e.target.files[0];
        form.preview = URL.createObjectURL(e.target.files[0])
    }

    const submit = () => {
        // console.log(form);
        form.post(route("register"), {
            onError: () => form.reset("password", "password_confirmation"),
        })
    };
</script>

<template>
     
    <Head :title="` | ${ $page.component }`" />

    <h1 class="title text-center">Register a new account</h1>

    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">
            <!-- Upload Avatar -->
            <div class="grid place-items-center">
                <div class="avatar-container">
                    <label for="avatar" class="avatar-label" />
                    <span class="avatar-preview-text">Avatar</span>
                    <input type="file" id="avatar" @input="change" hidden/>

                    <img class="avatar-image" :src="form.preview ?? 'storage/avatars/user_icon.png'" alt="">
                </div>
                    <p class="error mt-2">{{ form.errors.avatar }}</p>
            </div>

            <TextInput 
                name="name" 
                type="name" 
                v-model="form.name" 
                :message="form.errors.name" 
            />
            <TextInput 
                name="email" 
                type="email" 
                v-model="form.email" 
                :message="form.errors.email" 
            />
            <TextInput 
                name="password" 
                type="password" 
                v-model="form.password" 
                :message="form.errors.password" 
            />
            <TextInput 
                name="confirm_password" 
                type="password" 
                v-model="form.password_confirmation"
            />

            <!-- <div class="mb-6">
                <label>Name</label>
                <input type="text" v-model="form.name" />
                <small>{{ form.errors.name }}</small>
            </div>
            <div class="mb-6">
                <label>Email</label>
                <input type="email" v-model="form.email" />
                <small>{{ form.errors.email }}</small>
            </div>
            <div class="mb-6">
                <label>Password</label>
                <input type="password" v-model="form.password" />
                <small>{{ form.errors.password }}</small>
            </div>
             <div class="mb-6">
                <label>Confirm Password</label>
                <input type="password" v-model="form.password_confirmation" />
            </div> -->

            <div>
                <p class="text-slate-600 mb-2">Already a user account? <a :href="route('login')" class="text-link" >Login</a></p>
                <button class="primary-btn" :disabled="form.processing">Register</button>
            </div>
        </form>
    </div>
</template>
