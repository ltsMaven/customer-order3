document.addEventListener("DOMContentLoaded", () => {
	const addItemBtn = document.getElementById("add-item");
	const modalBody = document.getElementById("specModal-body");
	const editModalEl = document.getElementById("editItemModal");
	const editForm = document.getElementById("edit-item-form");
	const bsEdit = new bootstrap.Modal(editModalEl);

	if (!addItemBtn || !modalBody) return;

	// —— DELETE: one delegated listener for all .delete-item buttons ——
	modalBody.addEventListener("click", async (e) => {
		const btn = e.target.closest(".delete-item");
		if (!btn) return;

		const itemId = btn.dataset.id;
		if (!itemId) {
			return alert("Error: missing item ID");
		}
		if (!confirm("Delete this item?")) return;

		try {
			const res = await fetch(`${window.DELETE_ITEM_URL}/${itemId}`, {
				method: "POST", // CI3 handles POST out-of-the-box
				credentials: "same-origin",
			});
			if (!res.ok) {
				throw new Error(`HTTP ${res.status}`);
			}
			const json = await res.json();
			if (json.success) {
				btn.closest("tr").remove();
			} else {
				alert("Delete failed: " + (json.error || "unknown"));
			}
		} catch (err) {
			console.error("Delete error:", err);
			alert("Network error deleting item");
		}
	});

	// —— ADD ITEM: mostly your existing code, but appends with delete-item class & real ID ——
	addItemBtn.addEventListener("click", async () => {
		const item = {
			tate_yoko: document.getElementById("tate").value,
			ikatan: document.getElementById("ikatan").value,
			description: document.getElementById("description").value,
			size: document.getElementById("size").value,
			satuan: document.getElementById("satuan").value,
			width: document.getElementById("width").value,
			length: document.getElementById("length").value,
			satuan_panjang: document.getElementById("satuan_panjang").value,
			color: document.getElementById("color").value,
			jumlah: document.getElementById("jumlah").value,
		};
		if (
			!item.tate_yoko ||
			!item.ikatan ||
			!item.description ||
			!item.size ||
			!item.satuan ||
			!item.width ||
			!item.length ||
			!item.satuan_panjang ||
			!item.color ||
			!item.jumlah
		) {
			return alert("Please fill in all the fields");
		}

		try {
			const res = await fetch(window.ADD_ITEM_URL, {
				method: "POST",
				credentials: "same-origin",
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify({ item }),
			});
			const json = await res.json();
			if (!json.success) {
				return alert("Failed to save item");
			}

			// remove empty-state row
			const emptyRow = modalBody.querySelector("td[colspan]");
			if (emptyRow) emptyRow.closest("tr").remove();

			// append new row with correct data-id
			const tr = document.createElement("tr");

			// 1) set up your data-* on the element
			tr.dataset.id = json.id;
			tr.dataset.tate = item.tate_yoko;
			tr.dataset.ikatan = item.ikatan;
			tr.dataset.description = item.description;
			tr.dataset.size = item.size;
			tr.dataset.satuan = item.satuan;
			tr.dataset.width = item.width;
			tr.dataset.length = item.length;
			tr.dataset.satuan_panjang = item.satuan_panjang;
			tr.dataset.color = item.color;
			tr.dataset.jumlah = item.jumlah;

			// 2) now fill the HTML (make sure you include both buttons!)
			tr.innerHTML = `
  <td>${item.description}</td>
  <td class="text-center">${item.jumlah}</td>
  <td class="text-end">
    <button type="button" class="btn btn-sm btn-outline-warning edit-item">
      Edit
    </button>
    <button type="button" class="btn btn-sm btn-outline-danger delete-item" data-id="${json.id}">
      Delete
    </button>
  </td>
`;

			// 3) append it
			modalBody.appendChild(tr);

			// clear inputs
			[
				"tate",
				"ikatan",
				"description",
				"size",
				"satuan",
				"width",
				"length",
				"satuan_panjang",
				"color",
				"jumlah",
			].forEach((id) => (document.getElementById(id).value = ""));

			new bootstrap.Modal(document.getElementById("specModal")).show();
		} catch (err) {
			console.error("Add-item error:", err);
			alert("Network error adding item");
		}
	});

	const I = (id) => document.getElementById(id);

	// 1) when “Edit” clicked, populate & show
	modalBody.addEventListener("click", (e) => {
		const btn = e.target.closest(".edit-item");
		if (!btn) return;

		const tr = btn.closest("tr");
		const D = tr.dataset; // all data-*

		// fill hidden ID + each field
		I("edit-id").value = D.id;
		I("edit-tate").value = D.tate;
		I("edit-ikatan").value = D.ikatan;
		I("edit-description").value = D.description;
		I("edit-size").value = D.size;
		I("edit-satuan").value = D.satuan;
		I("edit-width").value = D.width;
		I("edit-length").value = D.length;
		I("edit-satuan-panjang").value = D.satuan_panjang;
		I("edit-color").value = D.color;
		I("edit-jumlah").value = D.jumlah;

		bsEdit.show();
	});

	// 2) when “Save changes”
	I("save-item-edit").addEventListener("click", async () => {
		// gather
		const payload = {
			tate_yoko: I("edit-tate").value,
			ikatan: I("edit-ikatan").value,
			description: I("edit-description").value,
			size: I("edit-size").value,
			satuan: I("edit-satuan").value,
			width: I("edit-width").value,
			length: I("edit-length").value,
			satuan_panjang: I("edit-satuan-panjang").value,
			color: I("edit-color").value,
			jumlah: I("edit-jumlah").value,
		};
		const itemId = I("edit-id").value;

		// basic client validation
		if (!payload.description || !payload.jumlah) {
			return alert("Description & quantity required");
		}

		try {
			const res = await fetch(
				`${window.DELETE_ITEM_URL.replace("/delete", "/update")}/${itemId}`,
				{
					method: "POST",
					credentials: "same-origin",
					headers: { "Content-Type": "application/json" },
					body: JSON.stringify(payload),
				}
			);
			if (!res.ok) throw new Error(`HTTP ${res.status}`);
			const json = await res.json();
			if (!json.success) {
				return alert("Update failed: " + (json.error || "unknown"));
			}

			// 3) reflect changes in the table row
			const row = modalBody.querySelector(`tr[data-id="${itemId}"]`);
			// update its dataset
			Object.keys(payload).forEach((k) => {
				row.dataset[k] = payload[k];
			});
			// update the two visible cells
			row.children[0].textContent = payload.description;
			row.children[1].textContent = payload.jumlah;

			bsEdit.hide();
		} catch (err) {
			console.error("Update error:", err);
			alert("Network error updating item");
		}
	});
});
