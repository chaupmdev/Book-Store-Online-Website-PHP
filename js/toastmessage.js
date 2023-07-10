const buttons = document.querySelectorAll(".buttons .btn");
const notifications = document.querySelector(".notifications");

const removeToast = (toast) => {
    toast.classList.add("remove");
    setTimeout(() => toast.remove(), 500);
};
// fa-check-circle
// fa-times-circle
// fa-exclamation-circle
// fa-info-circle
const toastDetails = {
    info: {
        icon: "fa-info-circle",
        title: "Thông báo : ",
    },
    error: {
        icon: "fa-times-circle",
        title: "Error : ",
    },
    warning: {
        icon: "fa-exclamation-circle",
        title: "Warning : ",
    },
    success: {
        icon: "fa-check-circle",
        title: "Thành công: ",
    },
};
const handleCreateToast = (id, message, typeid = null) => {
    if ( typeid != null && document.getElementById(typeid))
        return;
    const { icon, title } = toastDetails[id];
    const toast = document.createElement("li");
    toast.id = typeid
    toast.className = `toast-design ${id}`;
    toast.innerHTML = `<div class="column">
                          <i class="fa ${icon}"></i>
                          <span>${title} ${message}</span>
                        </div>
                        <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>`
    notifications.appendChild(toast);
    setTimeout(() => removeToast(toast), 5000);
};
//buttons.forEach((button) => {
//    button.addEventListener("click", () => {
//        handleCreateToast(button.id);
//    });
//});

//handleCreateToast("success","Cập thật thông tin thành công");

//handleCreateToast("error");
