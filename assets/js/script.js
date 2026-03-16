function handleImageError(img) {
    img.onerror = null;
    img.src = "/assets/imgs/backup-img.png";
}