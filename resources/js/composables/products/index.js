import { ref } from "vue";

export default function useProduct() {

    const products = ref([]);
    const cartCount = ref(0);

    const add = async (productId) => {
        let response = await axios.post('/api/cart', { productId: productId });
        return response.data.count;
    }

    const getProducts = async () => {
        let response = await axios.get('/api/cart');
        products.value = response.data.cartContent;
        cartCount.value = response.data.cartCount;
    }

    const getCount = async () => {
        let response = await axios.get("/api/cart/count");
        return response.data.count;
    }

    const decreaseQuantity = async (index) => {
        await axios.put('/api/cart/decrease/' + products.value[index].id);
    }

    const increaseQuantity = async (index) => {
        await axios.put('/api/cart/increase/' + products.value[index].id);
    }

    const deleteProduct = async (index) => {
        await axios.delete('/api/cart/' + products.value[index].id);
    }

    return {
        add,
        getCount,
        getProducts,
        decreaseQuantity,
        increaseQuantity,
        deleteProduct,
        products,
        cartCount,
    }

}
