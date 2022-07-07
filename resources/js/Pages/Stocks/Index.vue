<script setup>
import {Head, useForm, usePage} from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import AddStockButton from "@/Components/Button.vue";
import CreateProductModal from "@/Components/Modal.vue";
import EditProductModal from "@/Components/Modal.vue";
import SaveButton from "@/Components/SaveButton.vue";
import Swal from "sweetalert2";
import {computed, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    type: {
        type: String,
        default: 'button',
    },
    errors: Object,
    message: String,
    stocks: Object,
});
const showCreateModal = ref(false);
const showEditModal = ref(false);
const flashMessage = computed(() => usePage().props.value.flash.message)
const auth_user = computed(() => usePage().props.value.auth.user);

let newStockForm = useForm({
    name: null,
    brand: null,
    price: null,
    count_in_stock: null,
    description: null,
});
let editStockForm = useForm({
    id: null,
    name: null,
    brand: null,
    price: null,
    count_in_stock: null,
    description: null,
});

const saveStock = () => {
    newStockForm.post('/create-stock', {
        onSuccess: visit => {
            newStockForm.reset();
            showCreateModal.value = false;
            setTimeout(function () {
                Swal.fire({
                    title: 'Success',
                    text: flashMessage.value,
                    icon: 'success',
                });
            }, 100);
        },
    });
};
const editModal = (id) => {
    showEditModal.value = true;
    const stock = usePage().props.value.stocks.find(stock => stock.id === id);
    editStockForm.id = stock.id;
    editStockForm.name = stock.name;
    editStockForm.brand = stock.brand;
    editStockForm.price = stock.price;
    editStockForm.count_in_stock = stock.count_in_stock;
    editStockForm.description = stock.description;
}
const editStock = (id) => {
    editStockForm.post(`/update-stock/${id}`, {
        onSuccess: visit => {
            editStockForm.reset();
            showEditModal.value = false;
            setTimeout(function () {
                Swal.fire({
                    title: 'Success',
                    text: flashMessage.value,
                    icon: 'success',
                });
            }, 100);
        },
    });
};
const deleteStock = (id) => {
    Inertia.delete(`/destroy/${id}`);
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
                <AddStockButton :type=type @click="showCreateModal =true">
                    Add Stock
                </AddStockButton>
            </div>
        </template>
        <template #content>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless align-middle">
                            <thead class="table-dark">
                            <tr>
                                <th class="p-3" style="min-width: 150px;">Product Name</th>
                                <th class="p-3" style="min-width: 150px;">Product Brand</th>
                                <th class="p-3" style="min-width: 150px;">Product Price</th>
                                <th class="p-3" style="min-width: 250px;">Product Count in Stock</th>
                                <th class="p-3" style="min-width: 250px;">Product Description</th>
                                <th class="p-3" style="min-width: 150px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="$props.stocks.length === 0">
                                <td colspan="6" class="text-center">There is no data to show.</td>
                            </tr>
                            <tr v-else v-for="stock in $props.stocks">
                                <th scope="row">{{ stock.name }}</th>
                                <td>{{ stock.brand }}</td>
                                <td>{{ stock.price }}</td>
                                <td>{{ stock.count_in_stock }}</td>
                                <td>{{ stock.description }}</td>
                                <td>
                                    <button :class="[stock.user_id === auth_user.id ? '': 'disabled']" class="btn btn-warning me-2" @click="editModal(stock.id)"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button :class="[stock.user_id === auth_user.id ? '': 'disabled']" class="btn btn-danger me-2" @click="deleteStock(stock.id)"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </template>
    </BreezeAuthenticatedLayout>
    <CreateProductModal :show="showCreateModal" @close="showCreateModal=false">
        <template #header>
            <h3>Add Stock</h3>
        </template>
        <template #body>
            <form @submit.prevent="saveStock">
                <div class="modal-body">
                    <slot name="body">
                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Name : </label>
                            <input
                                type="text"
                                v-model="newStockForm.name"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.name">{{ errors.name }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Brand : </label>
                            <input
                                type="text"
                                v-model="newStockForm.brand"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.brand">{{ errors.brand }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Price : </label>
                            <input
                                type="text"
                                v-model="newStockForm.price"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.price">{{ errors.price }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Count : </label>
                            <input
                                type="text"
                                v-model="newStockForm.count_in_stock"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.count_in_stock">{{ errors.count_in_stock }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Description : </label>
                            <input
                                type="text"
                                v-model="newStockForm.description"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                        </div>
                    </slot>
                </div>
                <SaveButton class="modal-default-button btn btn-success">
                    Save
                </SaveButton>
            </form>
        </template>
    </CreateProductModal>
    <EditProductModal :show="showEditModal" @close="showEditModal=false">
        <template #header>
            <h3>Edit Stock</h3>
        </template>
        <template #body>
            <form @submit.prevent="editStock(editStockForm.id)">
                <div class="modal-body">
                    <slot name="body">
                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Name : </label>
                            <input
                                type="text"
                                v-model="editStockForm.name"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.name">{{ errors.name }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Brand : </label>
                            <input
                                type="text"
                                v-model="editStockForm.brand"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.brand">{{ errors.brand }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Price : </label>
                            <input
                                type="text"
                                v-model="editStockForm.price"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.price">{{ errors.price }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Count : </label>
                            <input
                                type="text"
                                v-model="editStockForm.count_in_stock"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                            <div class="text-sm text-red-600" v-if="errors.count_in_stock">{{ errors.count_in_stock }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Stock Description : </label>
                            <input
                                type="text"
                                v-model="editStockForm.description"
                                name="text"
                                id="text"
                                class="form-control rounded"
                                :class="[errors.name ? 'border-red-600':'accent-gray-700']"
                            />
                        </div>
                    </slot>
                </div>
                <SaveButton class="modal-default-button btn btn-success">
                    Edit
                </SaveButton>
            </form>
        </template>
    </EditProductModal>
</template>
