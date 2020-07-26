<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <span class="navbar-brand mb-0 h1">CareerBoard</span>

                <div>
                    <router-link v-bind:to="{name: 'search'}">
                        <button class="btn btn-success">Search</button>
                    </router-link>
                    <router-link v-bind:to="{name: 'user_create'}">
                        <button class="btn btn-success">Add</button>
                    </router-link>
                    <router-link v-bind:to="{name: 'user'}">
                        <button class="btn btn-success">List</button>
                    </router-link>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {}
</script>