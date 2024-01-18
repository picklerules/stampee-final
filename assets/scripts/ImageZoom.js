// Crée une classe pour gérer le zoom des images
export default class ImageZoom {
    constructor(zoomLevel) {
      this.zoomLevel = zoomLevel;
      this.attachListenersToAllImages();
    }
  
    attachListenersToAllImages() {
      const images = document.querySelectorAll('[data-js-component="image-zoom"]');
  
      images.forEach((imageElement) => {
        imageElement.addEventListener('mouseenter', () => {
          imageElement.style.transform = `scale(${this.zoomLevel})`;
        });
  
        imageElement.addEventListener('mouseleave', () => {
          imageElement.style.transform = 'scale(1)';
        });
      });
    }
  }
  
  
  