const tour ={
    id: "skuflow-demo",
    showPrevButton: true,
    scrollTopMargin: 100,
    steps: [
        {
            target: "basic_info",
            title: "Product Basic Information",
            content: `Essential product details for system management:<br><br>
                    <div class="tour-feature-list">
                        <div class="feature-item">
                            <i class="mdi mdi-tag-outline"></i>
                            <strong>Type*</strong>: Product category (e.g., "Electronics")
                        </div>
                        <div class="feature-item">
                            <i class="mdi mdi-barcode-scan"></i>
                            <strong>SKU*</strong>: Unique inventory identifier
                        </div>
                        <div class="feature-item">
                            <i class="mdi mdi-rename-box"></i>
                            <strong>Name*</strong>: Product title
                        </div>
                        <div class="feature-item">
                            <i class="mdi mdi-circle-slice-8"></i>
                            <strong>Status*</strong>: Active/Draft/Discontinued
                        </div>
                        <div class="feature-item">
                            <i class="mdi mdi-earth"></i>
                            <strong>Origin</strong>: Manufacturing country
                        </div>
                        <div class="feature-item">
                            <i class="mdi mdi-factory"></i>
                            <strong>Brand</strong>: Manufacturer
                        </div>
                        <div class="feature-item">
                            <i class="mdi mdi-palette"></i>
                            <strong>Collection</strong>: Product line/season
                        </div>
                    </div>
                    <div class="tour-note">
                        <i class="mdi mdi-alert-circle"></i> Fields marked with * are required
                    </div>`,
            placement: "bottom",
            yOffset: 10,
            width: 350,
            showCTAButton: true,
            ctaLabel: "Auto-fill Basic Info",
            onCTA: function() {
                // Example auto-fill functionality
                $('#product_type').val(1).trigger('change');
                $('#statusP').val(1).trigger('change');
                $('#origin').val(1).trigger('change');
                $('#brand').val(1).trigger('change');
                $('#sku').val('SKU-' + Math.floor(Math.random() * 1000));
                $('#name').val('Sample Product');
                $('#collection').val('Summer 2025');
                
            }
        },
        {
            target: "category_info",
            title: "Product Categorization",
            content: `This section allows you to manage product categorization:<br><br>
                    <div class="tour-feature-grid">
                        <div class="feature-card">
                            <i class="mdi mdi-plus-circle"></i>
                            <strong>Add Category</strong>: Create new product categories
                        </div>
                        <div class="feature-card">
                            <i class="mdi mdi-checkbox-multiple-marked"></i>
                            <strong>Bulk Selection</strong>: Check all/uncheck controls
                        </div>
                        <div class="feature-card">
                            <i class="mdi mdi-magnify"></i>
                            <strong>Search</strong>: Find specific categories quickly
                        </div>
                        <div class="feature-card">
                            <i class="mdi mdi-file-tree"></i>
                            <strong>Categories List</strong>: Hierarchical category structure
                        </div>
                    </div>
                    <div class="tour-tip">
                        <i class="mdi mdi-lightbulb-on"></i> Products can belong to multiple categories simultaneously
                    </div>`,
            placement: "left",
            zindex: 9999,
            width: 380,
            showCTAButton: true,
            ctaLabel: "Select a Category",
            onCTA: function() {
                // Example expand functionality
                $("#jstree").jstree("check_node", 2);
                var dataCategory = $('#jstree').jstree().get_selected(true);
                $("#jstree").jstree("open_node", parseInt(dataCategory[0].parent));
            }
        },
        {
            target: "displayImagesInfo",
            title: "Display Images",
            content: `
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="border: 1px dashed #4a90e2; padding: 10px; border-radius: 5px;">
                        <strong>Main Image</strong><br>
                        <em>Recomendado: 800x800px</em>
                    </div>
                    <div style="border: 1px dashed #4a90e2; padding: 10px; border-radius: 5px;">
                        <strong>Other Images</strong><br>
                        <em>Máx. 10 imágenes</em>
                    </div>
                </div>`,
            placement: "bottom",
            width: 300,
            xOffset: 20,
            yOffset: 10,
            zindex: 10000,
            fixedElement: true,
            onShow: function() {
                // Forzar scroll y asegurar visibilidad
                const element = document.getElementById('cardCollpaseImg');
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            },
        },
        {
            target: "inventoryInfo",
            title: "Inventory Management",
            content: "This section contains all configurations related to product inventory.",
            placement: "top",
            fixedElement: true,
            zindex: 10002,
            onShow: function() {
                // Asegurar que la sección esté expandida
                const collapseElement = document.getElementById('cardCollpaseInventory');
                if (collapseElement && !collapseElement.classList.contains('show')) {
                    new bootstrap.Collapse(collapseElement, { toggle: true });
                }
            },
            onNext: function() {
                // Activar la pestaña de Pricing
                new bootstrap.Tab(document.querySelector('#pricingTab')).show();
                const content = document.querySelector('#offcanvasRight .offcanvas-body');
                content.scrollTop = content.scrollHeight;
            }
        },
        {
            target: "#pricingTab",
            title: "Pricing Configuration",
            content: `<div class="tour-price-section">
                        <div class="price-item">
                            <i class="mdi mdi-currency-usd"></i>
                            <strong>Regular Price:</strong> Retail selling price
                        </div>
                        <div class="price-item">
                            <i class="mdi mdi-package-variant"></i>
                            <strong>Wholesale Price:</strong> Discounted price for bulk purchases
                        </div>
                        <div class="price-item">
                            <i class="mdi mdi-alert-circle"></i>
                            <strong>MAP:</strong> Minimum Advertised Price
                        </div>
                    </div>`,
            placement: "right",
            width: 350,
            zindex: 10003,
            showCTAButton: true,
            ctaLabel: "Auto-fill Pricing",
            onCTA: function() {
                // Example expand functionality
                $("#price").val(1099);
                $("#wholesale_price").val(1000);
                $("#map").val(1009);
                $("#msrp").val(1010);
            },
            
        },
        {
            target: "#dimensionTab",
            title: "Product Dimensions",
            content: `<div class="dimension-tour">
                        <div class="dimension-item">
                            <i class="mdi mdi-ruler"></i>
                            <strong>Main Dimensions:</strong>
                            <ul>
                                <li>Height</li>
                                <li>Width</li>
                                <li>Depth</li>
                            </ul>
                        </div>
                        <div class="dimension-item">
                            <i class="mdi mdi-weight-kilogram"></i>
                            <strong>Weight:</strong> Specify including packaging
                        </div>
                    </div>`,
            placement: "right",
            width: 350,
            zindex: 10004,
            showCTAButton: true,
            ctaLabel: "Auto-fill Measurements",
            onCTA: function() {
                // Example expand functionality
                $("#weight").val(1099);
                $("#weight_unit").val(2).trigger('change');
                $("#height").val(10);
                $("#width").val(20);
                $("#depth").val(30);
                $("#dimension_unit").val(6).trigger('change');
            },
            onShow: function() {
                new bootstrap.Tab(document.querySelector('#dimensionTab')).show();
                setTimeout(() => {
                    document.querySelector('#height').focus();
                }, 300);
            }
        },
        {
            target: "#attributesTab",
            title: "Product Attributes",
            content: `<div class="attributes-tour">
                        <div class="attribute-step">
                            1. Select attribute<br>
                            2. Choose value<br>
                            3. Add combination
                        </div>
                        <div class="attribute-tip">
                            <i class="mdi mdi-lightbulb-on"></i> Use for product variants
                        </div>
                    </div>`,
            placement: "right",
            width: 350,
            zindex: 10005,
            showCTAButton: true,
            ctaLabel: "Add Sample Attribute",
            onCTA: function() {
                let data = [
                {
                    'id': ULID.ulid(),
                    'attr_id': 1,
                    'name': "Color",
                    'value_id': 26,
                    'value': "Beige",
                },
                {
                    'id': ULID.ulid(),
                    'attr_id': 4,
                    'name': "Warranty",
                    'value_id': 7,
                    'value': "30 days limited warranty against manufacturer defects.",
                },
            ];
        
                $tableAttr.bootstrapTable('load', data);
            },
            onShow: function() {
                new bootstrap.Tab(document.querySelector('#attributesTab')).show();
            },
        },
        {
            target: "#extraTab",
            title: "Product Attributes",
            content: `<div class="attributes-tour">
                        <div class="attribute-step">
                            1. Select product part<br>
                            2. Choose Material<br>
                            2. Choose Color<br>
                            3. Add combination
                        </div>
                        <div class="attribute-tip">
                            <i class="mdi mdi-lightbulb-on"></i> Use for product details
                        </div>
                    </div>`,
            placement: "right",
            width: 350,
            zindex: 10005,
            showCTAButton: true,
            ctaLabel: "Add Extra Info",
            onCTA: function() {
                let data = [{
                    'id': ULID.ulid(),
                    'parts': "Top",
                    'parts_id': 1,
                    'material': "Aluminum",
                    'material_id': 1,
                    'color': "Silver",
                    'color_id': 47,
                }];
        
                $tableMC.bootstrapTable('append', data);
            },
            onShow: function() {
                new bootstrap.Tab(document.querySelector('#extraTab')).show();
            },
            onNext: function() {
                const el = document.querySelector('#aiCardDescription');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            },
        },
        {
            target: "aiCardDescription",
            title: "Product Descriptions",
            content: `<div class="description-tour">
                        <div class="ai-feature">
                            <i class="mdi mdi-robot"></i> <strong>AI Description Generator</strong>: 
                            Automatically creates SEO-optimized product descriptions
                        </div>
                        <div class="description-tips">
                            <strong>Best Practices:</strong>
                            <ul>
                                <li>Include key features and benefits</li>
                                <li>Use bullet points for readability</li>
                                <li>Incorporate relevant keywords</li>
                            </ul>
                        </div>
                    </div>`,
            placement: "left",
            zindex: 10006,
            width: 350,
            fixedElement: true,
            showCTAButton: true,
            ctaLabel: "Generate AI Description",
            onCTA: function() {
                document.getElementById('generate').click();
            },
            onNext: function() {
                const content = document.querySelector('#offcanvasRight .offcanvas-body');
                content.scrollTop = content.scrollHeight;
            }
        },
        {
            target: "#associationsTab",
            title: "Product Attributes",
            content: `<div class="bundle-tour">
                <div class="bundle-item">
                    <i class="mdi mdi-cube-outline"></i>
                    <strong>Select Products to Bundle</strong><br>
                    Choose existing products to include in the bundle.
                </div>
                <div class="bundle-item">
                    <i class="mdi mdi-counter"></i>
                    <strong>Quantity</strong><br>
                    Specify how many units of each product are included.
                </div>
                <div class="bundle-item">
                    <i class="mdi mdi-package-variant-closed"></i>
                    <strong>Child Products</strong><br>
                    Products that make up this bundled item.
                </div>
              </div>`,
            placement: "right",
            width: 350,
            zindex: 10005,
            showCTAButton: true,
            ctaLabel: "Add Extra Info",
            onCTA: function() {
                let data = [{
                    'id': ULID.ulid(),
                    'parts': "Top",
                    'parts_id': 1,
                    'material': "Aluminum",
                    'material_id': 1,
                    'color': "Silver",
                    'color_id': 47,
                }];
        
                $tableMC.bootstrapTable('append', data);
            },
            onShow: function() {
                new bootstrap.Tab(document.querySelector('#associationsTab')).show();
            },
            onNext: function() {
                const el = document.querySelector('#aiCardDescription');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            },
        },
        {
            target: "#shippingTab",
            title: "Shipping Configuration",
            content: `<div class="shipping-tour">
                        <div class="shipping-info">
                            <i class="mdi mdi-truck-delivery"></i>
                            <strong>Key Configurations:</strong>
                            <ul>
                                <li>Packaging type</li>
                                <li>Shipping class</li>
                                <li>Shipping dimensions</li>
                            </ul>
                        </div>
                    </div>`,
            placement: "top",
            width: 350,
            zindex: 10007,
            showCTAButton: true,
            ctaLabel: "Add Shipping Data",
            onCTA: function() {
                $('#package_type').val(1).trigger('change');
                $('#upc').val(12345678901);
                $('#barcode').trigger('click');
                $('#casepack').val(1);
                setTimeout(() => {
                    $('#pallet option[value="2"]').prop('selected', true);
                    $('#pallet').trigger('change');
                }, 500);
                
            },
            onShow: function() {
                new bootstrap.Tab(document.querySelector('#shippingTab')).show();
            },
        },
        {
            target: "notes_info",
            title: "Notes",
            content: `<div class="shipping-details-tour">
                        <i class="mdi mdi-truck-fast"></i>
                        <strong>Additional Information:</strong>
                        <ul>
                            <li>Estimated delivery time</li>
                            <li>Custom costs by zone</li>
                            <li>Shipping restrictions</li>
                        </ul>
                    </div>`,
            placement: "top",
            width: 300,
            zindex: 10008,
            fixedElement: true,
            showCTAButton: true,
            ctaLabel: "Add Note",
            onCTA: function() {
                $('#textNotes').val(`Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit orci, tincidunt non ultricies a, tincidunt quis lacus. Integer hendrerit fermentum laoreet. Donec elementum lacus et nulla malesuada vehicula. Proin in metus ut lorem pretium congue. Quisque vitae pellentesque elit, eget volutpat orci.Nam condimentum ante id nisl rhoncus viverra. In felis purus, tincidunt varius molestie vitae, iaculis vel est. Integer tempor luctus ligula, ut pulvinar elit. Fusce volutpat ex sit amet ante sagittis rutrum. Aliquam dapibus auctor ligula, non imperdiet nulla auctor et.   Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed pretium nec lacus et porttitor.  Curabitur sit amet varius ante. Etiam congue pharetra augue in cursus.`);
                
            },
        }
    ],
    i18n: {
        nextBtn: "Continue →",
        prevBtn: "← Back",
        doneBtn: "Finish Tour",
        skipBtn: "Exit Tour"
    }
};