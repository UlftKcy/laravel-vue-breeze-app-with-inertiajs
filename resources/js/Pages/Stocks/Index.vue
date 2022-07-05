<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import AddStockButton from "@/Components/Button.vue";
import CreateProductModal from "@/Components/Modal.vue";
import SaveButton from "@/Components/SaveButton.vue";

import {reactive, ref} from "vue";

defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
const showModal = ref(false);

let newStockForm = useForm({
    name: null,
    brand: null,
    price: null,
    count_in_stock: null,
    description: null,
});
const saveStock = ()=>{
    newStockForm.post('/create-stock',{
        onSuccess:()=>newStockForm.clearErrors(),
    });
};
</script>

<template>
    <Head title="Stocks"/>
    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Stocks
                </h2>
                <AddStockButton :type=type @click="showModal =true">
                    Add Stock
                </AddStockButton>
            </div>
        </template>
        <template #content>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </BreezeAuthenticatedLayout>
    <CreateProductModal :show="showModal" @close="showModal=false">
        <template #header>
            <h3>Add Stock</h3>
        </template>
        <template #body>
            <form @submit.prevent="saveStock">
                <div class="modal-body">
                    <slot name="body">
                        <div>
                            <label for="text" class="form-label">Stock Name : </label>
                            <input
                                type="text"
                                v-model="newStockForm.name"
                                name="text"
                                id="text"
                                class="form-control"
                            />
                        </div>
                        <div>
                            <label for="text" class="form-label">Stock Brand : </label>
                            <input
                                type="text"
                                v-model="newStockForm.brand"
                                name="text"
                                id="text"
                                class="form-control"
                            />
                        </div>
                        <div>
                            <label for="text" class="form-label">Stock Price : </label>
                            <input
                                type="text"
                                v-model="newStockForm.price"
                                name="text"
                                id="text"
                                class="form-control"
                            />
                        </div>
                        <div>
                            <label for="text" class="form-label">Stock Count : </label>
                            <input
                                type="text"
                                v-model="newStockForm.count_in_stock"
                                name="text"
                                id="text"
                                class="form-control"
                            />
                        </div>
                        <div>
                            <label for="text" class="form-label">Stock Description : </label>
                            <input
                                type="text"
                                v-model="newStockForm.description"
                                name="text"
                                id="text"
                                class="form-control"
                            />
                        </div>
                    </slot>
                </div>
                <SaveButton class="modal-default-button btn btn-success">
                    Kaydet
                </SaveButton>
            </form>
        </template>
    </CreateProductModal>
</template>
