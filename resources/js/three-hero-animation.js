import * as THREE from 'three';

export function initThreeHeroAnimation(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        console.error(`Canvas element with ID '${canvasId}' not found.`);
        return;
    }

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(window.devicePixelRatio);

    // Simple geometry: a rotating cube
    const geometry = new THREE.BoxGeometry(1.2, 1.2, 1.2); // Slightly larger cube
    const material = new THREE.MeshStandardMaterial({
        color: 0x4dd0e1, // A vibrant cyan color
        roughness: 0.5,
        metalness: 0.8,
        transparent: true,
        opacity: 0.7
    });
    const cube = new THREE.Mesh(geometry, material);
    scene.add(cube);

    // Add a subtle directional light to make the material visible
    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(0, 1, 1).normalize();
    scene.add(directionalLight);

    // Add ambient light for overall scene illumination
    const ambientLight = new THREE.AmbientLight(0x404040, 0.5);
    scene.add(ambientLight);

    camera.position.z = 5;
    cube.position.set(0, 0.5, 0); // Slightly offset the cube

    let animationId;

    function animate() {
        // Stop animation and clean up memory if user navigates away via Turbo
        if (!document.getElementById(canvasId)) {
            cancelAnimationFrame(animationId);
            renderer.dispose();
            return;
        }

        animationId = requestAnimationFrame(animate);

        cube.rotation.x += 0.01;
        cube.rotation.y += 0.01;

        renderer.render(scene, camera);
    }

    animate();

    // Handle window resizing (also checks if canvas exists)
    window.addEventListener('resize', () => {
        if (!document.getElementById(canvasId)) return;
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
}
