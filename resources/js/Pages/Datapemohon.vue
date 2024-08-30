<template>
    <Head title="Datapemohon" />
    <MainLayout title="Data Visitor">
        <div>
            <a1>(Approval berhasil ketika status "Approved by AVPkeamanan")</a1>
        </div>
        <template #header-action>
            <a href='/Badgeform/create'><BsButton v-if="can('Badgeform.create')"  type="primary" icon="plus">Tambah Pemohon</BsButton></a>
        </template>
        <div>
            <DxDataGrid ref="datagridRef" :data-source="dataSource" key="tr_badgeform_id" :column-auto-width="true"
                :remote-operations="remoteOperations" :item-per-page="10" @selection-changed="onSelectionChanged"
                :hover-state-enabled="true" @exporting="onExporting">
                <DxFilterRow :visible="true" />
                <DxExport :enabled="true" />
                <DxSelection select-all-mode="page" show-check-boxes-mode="always" mode="multiple" />
                <DxColumnChooser :enabled="true" mode="select" />
                <DxHeaderFilter :visible="true" />
                <DxPaging :page-size="10" />
                <DxPager :visible="true" :allowed-page-sizes="[10, 20, 50]" :show-page-size-selector="true" />

                <!-- Your columns here -->
                <DxColumn data-field="email" caption="Email" alignment="center"></DxColumn>
                <DxColumn data-field="nama" caption="Nama" alignment="center"></DxColumn>
                <DxColumn data-field="instansi" caption="Instansi"  alignment="center"></DxColumn>
                <DxColumn data-field="handphone" caption="Handphone"  alignment="center"></DxColumn>
                <DxColumn data-field="keperluan" caption="Keperluan"  alignment="center"></DxColumn>
                <DxColumn data-field="tujuan" caption="Tujuan"  alignment="center"></DxColumn>
                <DxColumn data-field="ms_komparteman_id" caption="Kompartemen"  alignment="center" cell-template="kompartemen"></DxColumn>
                <template #kompartemen="{ data }">
                    <span v-if="data.data.kompartemen == null">-</span>
                    <span v-else>{{ data.data.kompartemen.nama_kompartemen }}</span>
                </template>
                <DxColumn data-field="ms_departeman_id" caption="Departemen"  alignment="center" cell-template="departemen"></DxColumn>
                <template #departemen="{ data }">
                    <span v-if="data.data.departemen == null">-</span>
                    <span v-else>{{ data.data.departemen.nama_departemen }}</span>
                </template>
                <DxColumn data-field="durasi" caption="Durasi"  alignment="center"></DxColumn>
                <DxColumn data-field="tanggal" caption="Tanggal"  alignment="center"></DxColumn>
                <DxColumn data-field="jpemohon" caption="Jumlah Pemohon"  alignment="center"></DxColumn>
                <DxColumn data-field="status" caption="Status" cell-template="user-status"  alignment="center" :allowFiltering="true" :allowHeaderFiltering="true" data-type="enum"/>
                <DxColumn data-field="keterangan" caption="Keterangan"   alignment="center"></DxColumn>
               
                <template #user-status="{ data }">
                    <span v-if="data.data.status === '0'"
                    class="px-4 py-2 rounded-md bg-gray-500 text-white text-xs">Draft </span>
                        <span v-if="data.data.status === '1'"
                        class="px-4 py-2 rounded-md bg-gray-700 text-white text-xs">Waiting for Approval </span>
                        <span v-else-if="data.data.status === '2'"
                        class="px-4 py-2 rounded-md bg-success text-white text-xs">Approved by AVP</span>
                        <span v-else-if="data.data.status === '3'"
                        class="px-4 py-2 rounded-md bg-success text-white text-xs">Approved by VP</span>
                        <span v-else-if="data.data.status === '4'"
                        class="px-4 py-2 rounded-md bg-success text-white text-xs">Approved by SVP Operasi</span>
                        <span v-else-if="data.data.status === '5'"
                        class="px-4 py-2 rounded-md bg-success text-white text-xs">Approved by VP Keamanan</span>
                        <!-- <span v-else-if="data.data.status === '0'"
                        class="px-4 py-2 rounded-md bg-red-500 text-white text-xs">Reject</span> -->

                </template>
                <DxColumn cell-template="action" width="60" alignment="center" :allowExporting="false"
                    :showInColumnChooser="false" />
                <template #action="{ data }">
                    <el-dropdown trigger="click" placement="bottom-end">
                        <span class="el-dropdown-link">
                            <BsIcon icon="ellipsis-vertical" />
                        </span>
                        <template #dropdown>
                            <el-dropdown-menu >
                                

                                <el-dropdown-item v-if="can('Badgeform.update')"@click="editdata(data.data)">
                                    <BsIcon icon="pencil-square" class="mr-2" /> Edit
                                </el-dropdown-item>

                                <el-dropdown-item  v-if="can('Badgeform.approval')"  @click="Approval(data.data)"> 
                                    <BsIcon icon="newspaper" class="mr-2" /> Approval 
                                </el-dropdown-item>                   
                               
                                <el-dropdown-item v-if="can('Badgeform.delete')" @click="deleteData(data.data)">
                                    <BsIcon icon="trash" class="mr-2" /> Delete
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </template>

                <DxToolbar>
                    <DxItem location="before" template="buttonTemplate" />
                    <DxItem name="columnChooserButton" />
                    <DxItem name="exportButton" />
                    <DxItem widget="dxButton" :options="{ icon: 'refresh', onClick: refreshDatagrid }" />
                </DxToolbar>
                <template #buttonTemplate>
                    <div class="flex w-full">
                        <Transition name="fadetransition" mode="out-in" appear>
                            <div v-if="!itemSelected">
                                <!-- Table Action Here -->
                            </div>
                            <div v-else class="flex items-center border-2 border-primary-border rounded-full gap-1 text-sm">
                                <BsIconButton icon="x-mark" @click="clearSelection" />
                                <span class="font-bold mr-2">{{ dataSelected.length }} dipilih</span>

                                <div class="flex items-center border-l-2 px-2 h-full gap-1">
                                    <!-- Table Bulk Action -->
                                    <p class="font-semibold italic text-gray-700">No Action</p>
                                    <!-- End Table Bulk Action -->
                                </div>
                            </div>
                        </Transition>
                    </div>
                </template>
            </DxDataGrid>

            <!-- Delete Confirmation Dialog -->
            <el-dialog
    v-model="deleteDialogVisible"
    width="400px"
    title="Konfirmasi Penghapusan"
    custom-class="delete-dialog"
    center>
    <div class="flex flex-col items-center">
        <BsIcon icon="exclamation-circle" class="text-red-600 text-4xl mb-4" />
        <p class="text-gray-700 text-center mb-4">
            Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
        </p>
    </div>
    <span slot="footer" class="dialog-footer flex justify-center">
        <el-button @click="deleteDialogVisible = false" plain>Batal</el-button>
        <el-button 
            type="primary" 
            @click="confirmDelete" 
            class="ml-2 flex items-center justify-center" 
          >
            Hapus
        </el-button>
    </span>
</el-dialog>

        </div>
    </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link, router, Head, usePage } from '@inertiajs/vue3';
import BsButton from '@/Components/BsButton.vue';
import BsIconButton from '@/Components/BsIconButton.vue';
import { can } from '@/Core/Helpers/permission-check';
import {
    DxColumn,
    DxColumnChooser,
    DxDataGrid,
    DxExport,
    DxFormat,
    DxHeaderFilter,
    DxFilterRow,
    DxItem,
    DxPager,
    DxPaging,
    DxSelection,
    DxToolbar,
    DxButton
} from 'devextreme-vue/data-grid';
import CustomStore from "devextreme/data/custom_store";
import BsIcon from '@/Components/BsIcon.vue';
import { exportDataGrid } from 'devextreme/excel_exporter';
import { Workbook } from 'exceljs';
import { saveAs } from 'file-saver';
import { dxLoad } from '@/Core/Helpers/dx-helpers';
import DxPopup from "devextreme-vue/popup";
import DxList from "devextreme-vue/list";
import { ElMessage } from 'element-plus';


// Ref and Variables
const datagridRef = ref();
const dataSelected = ref([]);
const actionMenuVisible = ref(false);
const actionMenuTarget = ref(null);
const selectedRowData = ref(null);
// Variable to control the dialog visibility
const deleteDialogVisible = ref(false);
const deleteTarget = ref(null);

var itemSelected = computed(() => dataSelected.value.length > 0);

// Remote Operations
const remoteOperations = ref({
    paging: true,
    filtering: true,
    sorting: true,
});



// If you want to use server side processing
const dataKey = 'tr_badgeform_id'; //change to data primary key
const dataRoute = route('Badgeform.data_processing') //change to data processing route
const dataSource = new CustomStore({
    key: dataKey,
    load: dxLoad(dataRoute).bind(this),
});

// On Refresh Datagrid
function refreshDatagrid() {
    datagridRef.value.instance.refresh();
};

// On Selection Changed
function onSelectionChanged(data) {
    dataSelected.value = data.selectedRowsData;
};

// On Exporting
function onExporting(e) {
    const workbook = new Workbook();
    const worksheet = workbook.addWorksheet('Datapemohon');
    var fileName = "data-Datapemohon"

    exportDataGrid({
        component: e.component,
        worksheet,
        autoFilterEnabled: true,
    }).then(() => {
        workbook.xlsx.writeBuffer().then((buffer) => {
            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), fileName + '.xlsx');
        });
    });

    e.cancel = true;
};

// Clear Selection
function clearSelection() {
    const dataGrid = datagridRef.value.instance;
    dataGrid.clearSelection();
    dataSelected.value = [];
}

function editdata(dataedit){ 
    console.log(dataedit)
    router.visit(route('Editdata', dataedit.tr_badgeform_id));
}

function Approval(dataapproval) {
    console.log(dataapproval);
    router.visit(route( 'Requestdata', dataapproval.tr_badgeform_id ));
}

// Delete Data
// Function to open the delete confirmation dialog
function deleteData(data) {
    deleteTarget.value = data;
    deleteDialogVisible.value = true;
}

// Function to confirm the deletion
function confirmDelete() {
    if (deleteTarget.value) {
        router.delete(route('badgeform.delete', deleteTarget.value.tr_badgeform_id), {
            onSuccess: () => {
                refreshDatagrid();
                ElMessage({
                    message: 'Data berhasil dihapus',
                    type: 'success',
                });
                deleteDialogVisible.value = false;
            },
            onError: (errors) => {
                console.error(errors);
                ElMessage({
                    message: 'Terjadi kegagalan',
                    type: 'error',
                });
            },
        });
    }
}
</script>
<style scoped>
.el-button {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 15px; /* Sesuaikan padding sesuai kebutuhan */
    height: 36px; /* Sesuaikan tinggi tombol */
    line-height: 1; /* Pastikan line-height tidak mengganggu alignment */
}
</style>
