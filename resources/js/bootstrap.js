import axios from "axios";
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import $ from "jquery";
window.$ = $;

import DataTable from 'datatables.net-bs5';
window.DataTable = DataTable;

import "bootstrap-icons/font/bootstrap-icons.css"
import 'datatables.net-fixedcolumns-bs5';
import 'datatables.net-buttons';
import 'datatables.net-buttons-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-plugins/dataRender/ellipsis.mjs';
