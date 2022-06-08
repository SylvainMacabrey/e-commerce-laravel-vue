<template>
    <div class="flex items-center justify-between py-4">
        <button class="p-2 text-white bg-indigo-500" @click.prevent="addToCart">Ajouter au panier</button>
    </div>
</template>

<script setup>
    import useProduct from "../composables/products";
    import { inject } from "vue";

    const productId = defineProps(['productId']);
    const { add } = useProduct();
    const emitter = require('tiny-emitter/instance');
    const toast = inject('toast');

    const addToCart = async () => {
        await axios.get('sanctum/csrf-cookie');
        await axios.get('/api/user')
            .then(async (res) => {
               let cartCount = await add(productId);
               emitter.emit('cardCountUpdated', cartCount);
               toast.success('Produit ajouter au panier');

            })
            .catch((err) => {
                console.error(err);
                toast.error('Connecter vous pour ajouter un produit');
            });
    }
</script>

