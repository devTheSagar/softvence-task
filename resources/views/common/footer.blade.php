<script>
    document.addEventListener('DOMContentLoaded', () => {
        const moduleTemplate = document.querySelector('.module-template');
        const contentTemplate = document.querySelector('.content-template');
        const moduleContainer = document.getElementById('moduleContainer');

        document.getElementById('addModuleBtn').addEventListener('click', () => {
            const newModule = moduleTemplate.cloneNode(true);
            newModule.classList.remove('d-none', 'module-template');
            newModule.classList.add('module');

            // Content adder
            newModule.querySelector('.add-content-btn').addEventListener('click', () => {
            const contentContainer = newModule.querySelector('.contentContainer');
            const newContent = contentTemplate.cloneNode(true);
            newContent.classList.remove('d-none', 'content-template');

            newContent.classList.add('content');

            // Set content collapse ID
            const uniqueId = `content-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
            newContent.querySelector('.accordion-button').setAttribute('data-bs-target', `#${uniqueId}`);
            newContent.querySelector('.accordion-collapse').setAttribute('id', uniqueId);

            // Delete content button
            newContent.querySelector('.remove-content-btn').addEventListener('click', () => {
                newContent.remove();
                renumberContents(newModule);
            });

            contentContainer.appendChild(newContent);
            renumberContents(newModule);
            });

            // Module delete
            newModule.querySelector('.remove-module-btn').addEventListener('click', () => {
            newModule.remove();
            renumberModules();
            });

            moduleContainer.appendChild(newModule);
            renumberModules();
        });

        function renumberModules() {
            const modules = moduleContainer.querySelectorAll('.module');
            modules.forEach((mod, i) => {
            const headerBtn = mod.querySelector('.accordion-button');
            const collapse = mod.querySelector('.accordion-collapse');
            const collapseId = `module-collapse-${i + 1}`;

            headerBtn.innerText = `Module ${i + 1}`;
            headerBtn.setAttribute('data-bs-target', `#${collapseId}`);
            collapse.setAttribute('id', collapseId);

            // Renumber its contents
            renumberContents(mod);
            });
        }

        function renumberContents(moduleElement) {
            const contents = moduleElement.querySelectorAll('.content');
            contents.forEach((content, i) => {
            const btn = content.querySelector('.accordion-button');
            btn.innerText = `Content ${i + 1}`;
            });
        }
    });
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
