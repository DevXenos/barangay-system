import { showConfirmation } from "../functions/showConfirmation.js";
import showDialog from "../functions/showDialog.js";
import { showToast } from "../functions/showToast.js";
import setData from "../utils/setData.js";
const setTableAction = () => {
    $("#staffTable").find(".btn-delete").off("click").on("click", (e) => {
        const id = $(e.currentTarget).data("id");
        const firstName = $(e.currentTarget).data("first_name");
        showConfirmation({
            message: `Are you sure you want to delete this staff? ${firstName}`,
            onConfirm() {
                const data = setData({ id }, "delete");
                axios.post("/api/staff.php", data)
                    .then((result) => {
                    const data = result.data;
                    showToast(data.message, {
                        variant: data.status === 200 || data.status === 201 ? "success" : "error",
                    });
                })
                    .finally(() => {
                    $("#staffTable").load(window.location.href + " #staffTable", setTableAction);
                });
            },
        });
    });
    $("#staffTable").find(".btn-edit").off("click").on("click", (e) => {
        const id = $(e.currentTarget).data("id");
        const firstName = $(e.currentTarget).data("first_name");
        const lastName = $(e.currentTarget).data("last_name");
        const email = $(e.currentTarget).data("email");
        const phoneNumber = $(e.currentTarget).data("phone_number");
        const role = $(e.currentTarget).data("role");
        showDialog("addNewStaffModal", {
            onShow({ form }) {
                $("#addNewStaffLabel").text("Edit Staff");
                const defaults = { first_name: firstName, last_name: lastName, email, phone_number: phoneNumber, role };
                Object.entries(defaults).forEach(([name, value]) => {
                    $(form).find(`[name="${name}"]`).val(value);
                });
                const $password = $(form).find("[name='password']");
                $password.val("");
                $password.prop("required", false);
                $(form).find("button[type='submit']").text("Update Staff");
            },
            onSubmit({ data, modal }) {
                const payload = { ...data, id };
                if (!payload.password)
                    delete payload.password;
                const updatedData = setData(payload, 'put');
                axios.post("/api/staff.php", updatedData)
                    .then((result) => {
                    const data = result.data;
                    showToast(data.message, {
                        variant: data.status === 200 || data.status === 201 ? "success" : "error",
                    });
                })
                    .finally(() => {
                    $("#staffTable").load(window.location.href + " #staffTable", setTableAction);
                });
                modal.hide();
            }
        });
    });
};
$("#newNewStaffBtn").on("click", () => {
    showDialog("addNewStaffModal", {
        onShow({ form }) {
            $("#addNewStaffLabel").text("Add New Staff");
            $(form).find("button[type='submit']").text("Add Staff");
            const $password = $(form).find("[name='password']");
            $password.prop("required", true);
            form.reset();
        },
        onSubmit({ data, modal }) {
            const newData = setData(data);
            axios.post("/api/staff.php", newData)
                .then((result) => {
                const data = result.data;
                showToast(data.message, {
                    variant: data.status === 200 || data.status === 201 ? "success" : "error",
                });
            })
                .finally(() => {
                $("#staffTable").load(window.location.href + " #staffTable", setTableAction);
            });
            modal.hide();
        },
    });
});
setTableAction();
