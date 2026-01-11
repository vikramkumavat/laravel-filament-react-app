export default function getUserInitial(user) {
    const name = user?.name?.trim();
    return name ? name[0].toUpperCase() : "U";
}
