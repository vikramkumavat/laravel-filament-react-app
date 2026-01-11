// const isAuthenticated = () => {
//     return !!localStorage.getItem("token");
// };

// export default isAuthenticated;

const isAuthenticated = () => {
    const token = localStorage.getItem("token");
    const user = localStorage.getItem("user");

    return !!token && !!user;
};

export default isAuthenticated;
