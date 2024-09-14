<template>
    <div>
        <p class="p-4 bg-green-300 text-center">{{ $page.props.flash.greet }}</p>
        <h2 class="title">Welcom back {{ $page.props.auth.user.name }}</h2>
    </div>
</template>